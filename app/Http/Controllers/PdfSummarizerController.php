<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PdfSummarizerController extends Controller
{
    public function showForm()
    {
        return view('pdf.upload');
    }

    public function summarizePdf(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10240', // Max size: 10MB
        ]);

        $pdfExtension = $request->file('pdf')->getClientOriginalExtension();
        $pdfName = 'pdf_' . time() . '.' . $pdfExtension;
        $pdfPath = $request->file('pdf')->storeAs('uploads', $pdfName, 'public');

        // Extract text from the PDF
        $pdfText = $this->extractTextFromPdf($pdfPath);

        // Summarize the text using OpenAI GPT-3 API
        $summary = $this->summarizeTextWithGPT3($pdfText);

        // Display the result
        return view('pdf.summary', compact('summary'));
    }

    private function extractTextFromPdf($pdfPath)
    {
        try {
            // Execute pdftotext command to extract text
            $text = shell_exec("pdftotext " . storage_path("app/public/{$pdfPath} -"));
            // dd($text);

            if ($text === null) {
                throw new \Exception('PDF content extraction failed.');
            }

            return $text;
        } catch (\Exception $e) {
            // Print the error message
            dd($e->getMessage());
        }
    }

    private function sanitizeTextForGPT3($text)
    {
        // Remove non-UTF-8 characters
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

        // Remove control characters and non-printable characters
        $text = preg_replace('/[[:cntrl:]]/', '', $text);

        // Trim and limit the length of the text to avoid large requests
        $text = mb_substr(trim($text), 0, 4096); // Adjust the length as needed

        return $text;
    }
    private function summarizeTextWithGPT3($text)
    {
        $client = new Client();
    
        $apiKey = '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'; // Replace with your actual OpenAI API key THIS IS WRONG KEY
    
        // Sanitize the text before sending it to OpenAI API
        $text = $this->sanitizeTextForGPT3($text);
    
        // Customize the prompt for a more detailed summary
        $prompt = "i know this text is not in good form just get a main keyword or title from this text and sumrize this \n\n$text\n\n";
    
        $response = $client->post('https://api.openai.com/v1/engines/davinci/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ],
            'json' => [
                'prompt' => $prompt,
                'max_tokens' => 500, // Adjust the number of tokens as needed
            ],
        ]);
    
        $data = json_decode($response->getBody(), true);
    
        return $data['choices'][0]['text'] ?? '';
    }
    
    
}

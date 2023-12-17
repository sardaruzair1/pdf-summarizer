<!-- resources/views/pdf/upload.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Summarizer</title>
    <!-- Include Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <!-- Include any additional styles or scripts here -->
    <style>
        nav {
            background: rgba(255, 255, 255, 0.28);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            width: 80%;
            margin-top: 8px;
        }

        .containerg {

            background: rgba(255, 255, 255, 0.28);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            /* Change the font family as needed */
            background-color: #ffcb43;
            background-image: linear-gradient(319deg, #ffcb43 0%, #ff6425 37%, #ff0016 100%);

        }
    </style>
</head>

<body class="h-screen flex flex-col items-center justify-center bg-pink">

    <!-- Navbar -->
    <nav class="p-4 mb-8 border-b border-gray-300 fixed top-0">
        <div class="container mx-auto flex items-center justify-center">
            <span class="text-2xl font-bold text-gray-800">Sardar Uzair</span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="p-8 mx-4 sm:mx-auto rounded-md shadow-md containerg">
        <form action="/summarize" method="post" enctype="multipart/form-data"
            class="flex items-center justify-center flex-col">
            @csrf
            <label for="pdf" class="text-lg mb-4">Select a PDF file:</label>
            <input type="file" name="pdf" id="pdf" accept=".pdf" required class="border p-2 mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Summarize
                PDF</button>
        </form>
    </div>

</body>

</html>

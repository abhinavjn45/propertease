# Add chatbot CSS and JS to all HTML files in the project
$rootDir = "C:\Users\vishn\OneDrive\Desktop\propertease"

# Get all HTML files
$htmlFiles = Get-ChildItem -Path $rootDir -Filter "*.html" -Recurse

foreach ($file in $htmlFiles) {
    $content = Get-Content $file.FullName -Raw
    
    # Skip if already has chatbot
    if ($content -match "chatbot\.js") {
        Write-Host "SKIP (already has chatbot): $($file.FullName)"
        continue
    }
    
    # Determine relative path prefix
    $relDir = $file.DirectoryName
    $prefix = ""
    if ($relDir -ne $rootDir) {
        $prefix = "../"
    }
    
    # CSS link to add before </head>
    $cssLink = "        <!--<< Chatbot >>-->`r`n        <link rel=`"stylesheet`" href=`"${prefix}assets/css/chatbot.css`">"
    
    # JS to add before </body>
    $jsBlock = @"
        <!--<< Propert-Ease RAG Chatbot >>-->
        <script>
            // Paste your FREE Gemini API key below
            // Get it at: https://aistudio.google.com/apikey
            window.PROPERTEASE_GEMINI_KEY = 'YOUR_GEMINI_API_KEY_HERE';
        </script>
        <script src="${prefix}assets/js/chatbot.js"></script>
"@

    # Insert CSS before </head>
    $content = $content -replace "(</head>)", "$cssLink`r`n    `$1"
    
    # Insert JS before </body>
    $content = $content -replace "(</body>)", "$jsBlock`r`n    `$1"
    
    Set-Content -Path $file.FullName -Value $content -NoNewline
    Write-Host "UPDATED: $($file.FullName)"
}

Write-Host "`nDone! Chatbot added to all HTML files."

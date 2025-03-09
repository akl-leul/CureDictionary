const apiKey = 'e042ee13-63a6-4f40-bc3f-ba0a83a8780b';
const apiUrl = `https://www.dictionaryapi.com/api/v3/references/medical/json/`;

function searchTerm() {
    const searchInput = document.getElementById('search').value.trim();
    const resultsDiv = document.getElementById('results');
    
    // Clear previous results and show loading message
    resultsDiv.innerHTML = "<p>Loading...</p>";
    
    if (searchInput === "") { 
        resultsDiv.innerHTML = " <i class='fa-solid fa-triangle-exclamation' style='color: red;'></i><p style='color: red; font-weight: 700;'> Please enter a medical term to search.</p>"; // Clear loading message
        return;
    }

    const url = `${apiUrl}${searchInput}?key=${apiKey}`;
    
    // Fetching the data from the API
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error("Error fetching data from API");
            }
            return response.json();
        })
        .then(data => {
            displayResults(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('results').innerHTML = "<p>Something went wrong. Please try again later.</p>";
        });
    
    // Clear the input after search
    document.getElementById('search').value = '';
}

function displayResults(data) {
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = ""; // Clear previous results

    // Check if the response is empty or contains no data
    if (data.length === 0) {
        resultsDiv.innerHTML = "<p>No results found for this term.</p>";
        return;
    }

    // Loop through the response data and display results
    data.forEach(item => {
        // The headword (term)
        const term = item.hwi ? item.hwi.hw : "No term found";
        
        // The definitions of the term (shortdef is an array of definitions)
        const definitions = item.shortdef || ["No definitions available"];

        const termContainer = document.createElement('div');
        termContainer.classList.add('result-item');

        // Add the term (word) to the container
        const termElement = document.createElement('h3');
        termElement.textContent = term;
        termContainer.appendChild(termElement);

        // List the definitions
        const definitionList = document.createElement('ul');
        definitions.forEach(def => {
            const definitionItem = document.createElement('li');
            definitionItem.textContent = def;
            definitionList.appendChild(definitionItem);
        });

        termContainer.appendChild(definitionList);
        resultsDiv.appendChild(termContainer);
    });
}
 
        // Function to detect if developer tools are open
        function detectDevTools() {
            const threshold = 160; // Threshold width of devtools
            const devTools = /./;
            devTools.toString = function() {
                this.opened = true;
            };
            
            try {
                console.log(devTools);
            } catch (e) {}

            if (devTools.opened || window.outerWidth - window.innerWidth > threshold) {
                alert("Access to developer tools is not allowed on this website. Please respect our privacy policy.");
                // Optionally, redirect or block actions after detection
                window.location.href = "https://www.cure-dictionary.vercel.app"; // Example: redirecting to home page
            }
        }

        // Run the detection when the page is loaded
        window.onload = detectDevTools;
     

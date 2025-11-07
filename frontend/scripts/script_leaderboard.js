const BASE_URL = "http://localhost:8080/assignment_project/backend/apis/";

document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM loaded, initializing leaderboard...");
    getScores();
    document.getElementById("score-id").addEventListener("click", addScore);
});

async function getScores() {
    try {
        console.log("Fetching scores from:", BASE_URL + "get_score.php");
        const url = BASE_URL + "get_score.php";
        const response = await axios.get(url);
        const success = response.data.success; 
        const data = response.data.data;
        
        if (success) {
            console.log("Scores data received:", data);
            const tableBody = document.getElementById("leaderboard-body");
            
            if (!tableBody) {
                console.error("Leaderboard table body not found!");
                return;
            }
            
            tableBody.innerHTML = "";
            
            if (Array.isArray(data)) {
                data.forEach((player, index) => {
                    const durationfrmt = formatDuration(player.duration);
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${player.name}</td>
                            <td>${player.score}</td>
                            <td>${durationfrmt}</td>
                        </tr>`;
                    tableBody.innerHTML += row;
                });
                console.log("Leaderboard updated successfully");
            } else {
                console.error("Data is not an array:", data);
            }
        } else {
            console.error("API error:", response.data.error);
        }
    } catch (error) {
        console.error("ERROR fetching scores:", error);
        // Check if axios is available
        if (typeof axios === 'undefined') {
            console.error("Axios is not defined! Check if the script is loaded properly.");
        }
    }
}

async function addScore(x) {
    x.preventDefault();
    
    try {
        const playerName = document.getElementById("player-name").value.trim();
        const specialChars = /^[A-Za-z0-9_ ]+$/;
        
        if (playerName === "") {
            alert("Please enter your name");
            return;
        }
        
        if (!specialChars.test(playerName)) {
            alert("Name can only contain letters, numbers, spaces, and underscores.");
            return;
        }
        
        console.log("Adding score for player:", playerName);
        const url = BASE_URL + "add_score.php";
        const response = await axios.post(url, {
            name: playerName
        });
        
        console.log("Add score response:", response.data);
        
        if (response.data.status === "duplicate") {
            alert("You already have a score!");
            return;
        }
        
        if (response.data.success) {
            alert("Your Score is Submitted Successfully!");
            // Clear the input field
            document.getElementById("player-name").value = "";
            // Refresh the leaderboard
            getScores();
        } else {
            alert("Failed to submit score. Please try again.");
        }
        
    } catch (error) {
        console.error("Error adding score:", error);
        alert("Failed to add your score. Try again.");
    }
}

function formatDuration(seconds) {
    if (!seconds && seconds !== 0) return "0:00";
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${m}:${s.toString().padStart(2, '0')}`;
}


document.addEventListener("DOMContentLoaded", leaderbrd);

document.getElementById("score-id").addEventListener("click", function(x){
    x.preventDefault();

    const playerName = document.getElementById("player-name").value.trim();
    const specialChars = /^[A-Za-z0-9_ ]+$/;
    if (playerName === ""){
        alert(
            "please enter your name"
            );
        return;
    }
    if (!specialChars.test(playerName)) {
        alert("Name can only contain letters, numbers, spaces, and underscores.");
        return;
    }
    axios.post("http://localhost:8080/assignment_project/backend/apis/add_score.php", {name:playerName    
    }).then(response => {
    console.log(response);
    if (response.data.status === "duplicate") {
        alert("You already have a score!");
        return;
        }

        alert("Score submitted!");
        leaderbrd(); 
        }).catch(error => {
            console.error("Error adding score:", error);
            alert("Failed to add your score. Try again.");
            });
        });

function leaderbrd(){
    axios.get("http://localhost:8080/assignment_project/backend/apis/get_score.php")
    .then(response => {
            console.log(response) 
            const players = response.data;
            const tableBody = document.getElementById("leaderboard-body");
            tableBody.innerHTML="";
            players.forEach((player, index)=>{
                const durationfrmt = formatDuration(player.duration);
                    const row = `
                        <tr>
                        <td>${index + 1}</td>
                        <td>${player.name}</td>
                        <td>${player.score}</td>
                        <td>${durationfrmt}</td>
                        </tr>`;
                        tableBody.innerHTML += row;
                                    })

                }
            )
        }
function formatDuration(seconds) {
const m = Math.floor(seconds / 60);
const s = seconds % 60;
return `${m}:${s.toString().padStart(2, '0')}`;
}
leaderbrd()


        
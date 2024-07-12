<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Song</title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Montserrat:400,400i,700");

        body {
            font-family: 'Montserrat', sans-serif;
            text-align: center;
            background-color: #000000; /* Set black background for the entire page */
            margin: 0;
            padding: 0;
            color: #fff; /* Set text color to white */
        }

        .album {
    height: 250px;
    width: 250px;
    border-radius: 50%;
    margin-bottom: 25px;
    margin-right:25px;
    overflow: hidden;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 5px solid transparent; /* Transparent border for hover effect */
    transition: border-color 0.3s ease;
    transform: translateX(10%); /* Adjust horizontal position */
}

.album:hover {
    border-color: #45a049; /* Border color on hover */
    box-shadow: 0 0 20px #45a049; /* Neon glow effect on hover */

}

.album img {
    max-width: 100%; /* Ensure image does not exceed container width */
    max-height: 100%; /* Ensure image does not exceed container height */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(0deg); /* Initial rotation */
    animation: rotateImage 6s linear infinite;
        
}

@keyframes rotateImage {
    from {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    to {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

.music-details {
    font-size: 1rem;
    margin-top: 10px;
    padding: 0 20px; /* Add padding for better readability */
    text-align: center; /* Align details text center */
}

.player {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
}

.btn {
    background-color: transparent;
    border: none;
    cursor: pointer;
    outline: none;
    color: #fff;
    font-size: 2rem;
    margin: 0 10px;
}

.btn:hover {
    color: #45a049;
}

.bar, .bar-vol {
    height: 2px;
    width: 100%;
    background-color: #fff;
    margin: 10px 0;
     padding-top:25px;
}

.time, .time2 {
    color: #fff;
    margin: 10px 0;
}

.up, .down {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.fa-volume-up, .fa-volume-down {
    font-size: 2rem;
    color: #fff;
    cursor: pointer;
    margin: 0 10px;
}

.fa-volume-up:hover, .fa-volume-down:hover {
    color: #45a049;
}

.download-container {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
}

.download-btn {
    background-color: #45a049;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    text-decoration: none;
    transition: background-color 0.3s ease;
    display: block; /* Ensure button is block-level */
    width: 80%; /* Adjust width as needed */
    margin: auto; /* Center horizontally */
    margin-top: 10px; /* Add space between button and player */
}

.download-btn:hover {
    background-color: #35633e;
}

    </style>
</head>
<body>
    <div class="content">
        <?php
        if (isset($_GET['songname'])) {
            $songname = urlencode($_GET['songname']);
            $api_url = 'https://spotifyapi.nepdevsnepcoder.workers.dev/?songname=' . $songname;
            $json_data = file_get_contents($api_url);
            $songs = json_decode($json_data, true);

            if ($songs && count($songs) > 0) {
                $song = $songs[0]; // Assuming the first result is the desired song
                $download_url = htmlspecialchars($song['download_link']);
                $song_name = htmlspecialchars($song['song_name']);
                $artist_name = htmlspecialchars($song['artist_name']);
                $release_date = htmlspecialchars($song['release_date']);
                $popularity = htmlspecialchars($song['popularity']);
                $image_url = htmlspecialchars($song['image_url']);
echo "<center>";
                echo "<div class='album'>";
                echo "<img src='$image_url' class='album' alt='Album Image'>";
                echo "</div>";
                echo "<div class='bar'></div>";
                echo "<div class='music-details'>";
                echo "<h1>$song_name</h1>"; // Display only song name
                echo "<p>Artist: $artist_name</p>";
                echo "<p>Release Date: $release_date</p>";
                echo "<p>Popularity: $popularity</p>";
                echo "</div>";
                echo "<div class='player'>";
                echo "<button type='button' id='button_bw' class='btn'><i class='fa fa-step-backward'></i></button>";
                echo "<button type='button' id='button_play' class='btn' onclick='buttonPlayPress()'><i class='fa fa-play'></i></button>";
                echo "<button type='button' id='button_fw' class='btn'><i class='fa fa-step-forward'></i></button>";
                echo "</div>";
                echo "<div class='bar-vol'></div>";
            } else {
                echo "<p>No song found with the name: " . htmlspecialchars($_GET['songname']) . ".</p>";
            }
        } else {
            echo "<p>No song selected.</p>";
        }
        ?>
    </div>

    <div class="download-container">
        <?php if (isset($download_url)) : ?>
            <a href="<?php echo $download_url; ?>" class="download-btn" target="_blank" rel="noopener noreferrer">Download</a>
        <?php endif; ?>
    </div>

    <!-- Font Awesome CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <!-- JavaScript for player controls -->
    <script>
        var state = "stop";
        var audioPlayer = new Audio(); // Create a new Audio object

        function setupAudio(src) {
            audioPlayer.pause(); // Pause any existing playback
            audioPlayer.src = src; // Set the audio source
            audioPlayer.load(); // Load the audio
        }

        function buttonBackPress() {
            console.log("button back");
            // Implement functionality for previous track button if needed
        }

        function buttonPlayPress() {
            var button = document.getElementById('button_play');

            if (state == "stop") {
                state = "play";
                button.innerHTML = "<i class='fa fa-pause'></i>";
                setupAudio('<?php echo $download_url; ?>'); // Set up audio playback
                audioPlayer.play(); // Start playing
            } else if (state == "play" || state == "resume") {
                state = "pause";
                button.innerHTML = "<i class='fa fa-play'></i>";
                audioPlayer.pause(); // Pause playback
            } else if (state == "pause") {
                state = "resume";
                button.innerHTML = "<i class='fa fa-pause'></i>";
                audioPlayer.play(); // Resume playback
            }
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Songs</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            text-align: center;
            background-color: #000000;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #FFFFFF;
            margin-top: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .box1 {
            width: calc(45% - 20px);
            border: 2px solid black;
            background-color: #050708;
            border-radius: 2rem .3rem;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .box1:hover {
            background-color: rgba(165, 42, 42, 0.521);
            border-color: white;
        }
        .box1 img {
            width: 100%;
            height: auto;
            cursor: pointer;
        }
        .box1 .card-text {
            padding: 10px;
            text-align: left;
            color: #FFFFFF;
            font-size: 14px;
        }
        .box1 a {
            text-decoration: none;
            color: #FFFFFF;
        }
        .search-bar input[type="search"] {
            width: 40%;
            height: 38px;
            border: 1.5px solid yellow;
            text-align: center;
            border-radius: 1rem;
            font-size: 18px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .search-bar input[type="search"]:hover,
        .search-bar input[type="search"]:focus {
            border: 4px solid orangered;
        }
        .search-bar input[type="submit"] {
            background-color: orangered;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 1rem;
            font-size: 18px;
            cursor: pointer;
        }
        .search-bar input[type="submit"]:hover {
            background-color: #ff6347;
        }
        .section-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .section-buttons button {
            background-color: #FF6347;
            color: white;
            border: none;
            padding: 10px 15px; /* Reduced padding */
            border-radius: 1rem;
            font-size: 16px; /* Reduced font size */
            cursor: pointer;
            margin-bottom: 10px; /* Added margin-bottom for spacing */
        }
        .section-buttons button:hover {
            background-color: #FF4500;
        }
    </style>
</head>
<body>

    <h1>Spotify Songs</h1>
    <div class="search-bar">
        <form method="get" action="">
            <input type="search" name="songname" placeholder="Search for a song..." required>
            <input type="submit" value="Search">
        </form>
    </div>
    <div class="container">
        <?php
        if (isset($_GET['songname'])) {
            $songname = urlencode($_GET['songname']);
            $api_url = 'https://spotifyapi.nepdevsnepcoder.workers.dev/?songname=' . $songname;
            $json_data = file_get_contents($api_url);
            $songs = json_decode($json_data, true);

            if ($songs) {
                foreach ($songs as $song) {
                    echo '<div class="box1">';
                    echo '<a href="play.php?songname=' . urlencode($song['song_name']) . '">';
                    echo '<img src="' . $song['image_url'] . '" alt="' . htmlspecialchars($song['song_name']) . '">';
                    echo '</a>';
                    echo '<div class="card-text">';
                    echo '<h3>' . htmlspecialchars($song['song_name']) . '</h3>';
                    echo '<p>Artist: ' . htmlspecialchars($song['artist_name']) . '</p>';
                    echo '<p>Release Date: ' . htmlspecialchars($song['release_date']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No songs found.</p>';
            }
        }
        ?>
    </div>

</body>
</html>

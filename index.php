<!DOCTYPE HTML>
<html>
    <head>
        <title>Git commit log</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"/>

        <style>
            #maincontent {
                margin-bottom: 50px;
            }

			header {
				width: 100%;
			}
			header img {
				display: block;
				margin-top: -3px;
				height: 60px;
			}

            footer {
                text-align: center;
                border-top: 2px solid #337AB7;
                background-color: white;

                position: fixed;
                bottom: 0;
                padding-top: 5px;
                padding-bottom: 5px;
                width: 100%;
            }

			#line {
				border-bottom: 2px solid #337AB7;
				position: absolute;
				width: 100%;
				left: 0;
				top: 50px;
			}
        </style>
    </head>
    <body>
        <div id="line"></div>

        <div class="container" id="maincontent">
            <header>
				<img src="Logo.png"/>
			</header>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                        require_once('config.php');

                        $content = file_get_contents('data/.commits.txt');
                        $lines = explode(PHP_EOL, $content);
                        if (!$lines)
                            $lines = array();

                        foreach (array_reverse($lines) as $jsonString) {
                            $commitList = json_decode($jsonString);

                            // Ignore invalid json lines
                            if (!$commitList)
                                continue;

                            foreach (array_reverse($commitList) as $commit) {
                                $id = htmlspecialchars($commit->id);
                                if (USE_SHORT_HASHES)
                                    $id = substr($id, 0, 7);

                                $author = htmlspecialchars($commit->author);
                                $timestamp = htmlspecialchars(isset($commit->timestamp) ? $commit->timestamp : 'not available');
                                $message = nl2br(htmlspecialchars($commit->message));

                                echo "<tr><td>$id</td><td>$author</td><td>$timestamp</td><td>$message</td></tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>

        </div>

        <footer>
            by
            <a href="http://www.v-roleplay.net">vRoleplay</a> licensed under GPL v3.0 -
            <a href="https://github.com/vRoleplay/CommitLog">GitHub</a>
        </footer>
    </body>
</html>

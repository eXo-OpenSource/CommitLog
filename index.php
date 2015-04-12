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

            .draw_line {
               border-top: 3px solid #337AB7;
            }

            td img {
                width: 40px;
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
			<td></td>
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

                        $lastDay = 0;
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
                                
                                $css_class = '';
                                if (isset($commit->timestamp)) {
                                    $parsed_date = date_parse($commit->timestamp);
                                    if ($parsed_date['day'] != $lastDay)
                                        $css_class = 'draw_line';

                                    $lastDay = $parsed_date['day'];
				}

				$message = nl2br(htmlspecialchars($commit->message));
                                $url = htmlspecialchars(isset($commit->url) ? $commit->url : '');
                                $avatar_tag = isset($commit->avatar_url) ? "<img src=\"{$commit->avatar_url}\"/>" : '';

                                echo "<tr class=\"$css_class\"><td><a href=\"$url\">$id</a></td><td>$avatar_tag</td><td>$author</td><td>$timestamp</td><td>$message</td></tr>";
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

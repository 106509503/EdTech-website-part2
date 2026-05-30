<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn more about our company, our mission, and our values.">
    <meta name="keywords" content="about us, company, mission, values">
    <meta name="authors" content="Ton Hoang Do, David Tucker, Myles McCarthy and Oscar Hill">
    <link rel="stylesheet" href="styles/pagestyle.css">
    <link rel="stylesheet" href="styles/about-layout.css">
    <title>About Us</title>

    <style>
        /* Header (banner img) */
        header {
            display: flex;
            justify-content: center;
            background-color: #2c327c;
        }
    </style>

</head>
<body>
    <?php include 'extrafiles/header.inc'; 
    include 'extrafiles/nav.inc';
    ?>
    
    
    <main>
        <h1>About Our Team</h1>

        <!-- Introduction about our team -->
        <!-- Description under header centering -->
        <p style="text-align: center" style="margin-top: 5px">Welcome to our team! We are dedicated to providing the best services in the industry.</p>
        <hr id="article-break">
        <div class="article">
            <article>
                <section id="team">
                    <h2>Team name</h2>
                    <ul>
                        <li>We are the <strong>Jira Fanatics</strong>
                            <ul>
                                <li>We meet every week on Friday at 8:30am</li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- Member contributions and quotes -->
                <section id="members">
                    <h2>Our Members</h2>

                    <?php
                        require_once "extrafiles/settings.php";
                        $conn = @mysqli_connect($host,$user,$pwd,$sql_db);
                        $sql = "SELECT about_id, name, student_id, contribution, quote, translation FROM about_contributions";
                        $result = mysqli_query($conn, $sql);

                        if ($result->num_rows > 0) {
                            echo "<dl>";
                            while($row = mysqli_fetch_assoc($result)) {
                                    echo "<div>";
                                        echo "<dt>" . $row["name"] . "</dt>";
                                        echo "<dt style='font-style: italic' id='studentid'>Student ID: " . $row["student_id"] . "</dt>";
                                            echo "<dd>" . $row["contribution"];
                                                echo "<h3 id='quoteheading'>Favourite quote</h3>";
                                                echo "<ul>";
                                                    echo"<li>" . $row["quote"];
                                                    echo "<ul>";
                                                        echo "<li>" . $row["translation"] . "</li>";                                            
                                                    echo "</ul>";
                                                    echo "</li>";
                                                echo "</ul>";
                                            echo "</dd>";
                                    echo "</div>";
                            }
                            echo "</dl>";
                        }
                    
                        
                            /*<div>
                                <dt>David Tucker</dt>
                                <dt style="font-style: italic" id="studentid">Student ID: 105914164</dt>
                                    <dd>He created and formatted the Join Our Team page and was our point of communication to others through the Canvas Discussion Board should we have problems
                                        <h3 id="quoteheading">Favourite quote</h3>
                                        <ul>
                                            <li>"Carpe diem"
                                            <ul>
                                                <li>Seize the day</li>
                                            </ul>
                                            </li>
                                        </ul>
                                    </dd>
                            </div>
                            <div>
                                <dt id="member">Myles McCarthy</dt>
                                <dt style="font-style: italic" id="studentid">Student ID: 106564353</dt>
                                    <dd>He created and formatted the Career page and helped to create and manage Jira, our project management software, for the team, ensuring that the team followed the sprints laid out by Oscar
                                        <h3 id="quoteheading">Favourite quote</h3>
                                        <ul>
                                            <li>"Bättre en fågel i handen än tio i skogen"
                                            <ul>
                                                <li>A bird in the hand is worth two in the bush</li>
                                            </ul>
                                            </li>
                                        </ul>
                                    </dd>
                            </div>
                            <div>
                                <dt id="member">Oscar Hill</dt>
                                <dt style="font-style: italic" id="studentid">Student ID: 106509503</dt>
                                    <dd>He created and formatted this About Us page and, along with Myles, helped to create and manage Jira for the team, helping to split up the project into manageable 'sprints' of work
                                        <h3 id="quoteheading">Favourite quote</h3>
                                        <ul>
                                            <li>"Memento mori, memento vivere"
                                            <ul>
                                                <li>Remember you will die, remember to live</li>
                                            </ul>
                                            </li>
                                        </ul>
                                    </dd>
                            </div>*/
                    ?>
                </section>

                <!-- Fun fact table -->
                <section id="facts">
                    <h2>Fun Facts</h2>
                    <table>
                        <caption>Facts about our team</caption>
                        <thead>
                            <tr>
                            <th scope="col">Names</th>
                            <th scope="col">Ton Huang Do</th>
                            <th scope="col">David Tucker</th>
                            <th scope="col">Myles McCarthy</th>
                            <th scope="col">Oscar Hill</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">Dream job</th>
                            <td>Manager of nothing</td>
                            <td>Robotics Engineer</td>
                            <td>Zoology</td>
                            <td>Indie Developer</td>
                            </tr>
                            <tr>
                            <th scope="row">Hometown</th>
                            <td>Bac Lieu</td>
                            <td>Hurstbridge</td>
                            <td>Hobart</td>
                            <td>Sandringham</td>
                            </tr>
                            <tr>
                            <th scope="row">Favourite Cuisine</th>
                            <td>Chinese</td>
                            <td>Japanese</td>
                            <td>Indian</td>
                            <td>Southeast Asian</td>
                            </tr>
                            <tr>
                            <th scope="row">Interesting hobby</th>
                            <td>Mahjong</td>
                            <td>Making AI voice automations</td>
                            <td>Bouldering</td>
                            <td>Playing piano</td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </article>

            <!-- Group photo -->
            <div class="container">
                <figure>
                    <a href="images/about/group.jpg"><img src="images/about/group.jpg" alt="Photo of the team" title="Filesize 285kb"/></a>
                    <figcaption>From left to right: Ton Hoang Do, David Tucker, Myles McCarthy and Oscar Hill</figcaption>
                </figure>
            </div>	
        </div>
    </main>

    <hr id="footer-break">

    <?php include 'extrafiles/footer.inc'; ?>

</body>
</html>
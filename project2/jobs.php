<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fill out our application form to join our team!">
    <meta name="keywords" content="apply, application form, join our team, careers">
    <meta name="authors" content="Ton Hoang Do, David Tucker, Myles McCarthy and Oscar Hill">
    <link rel="stylesheet" href="styles/pagestyle.css">
    <link rel="stylesheet" href="styles/jobs-layout.css">
    <style>
        #apply-now {
            float: left; 
            width: 25%;
            margin: 5%;
            padding: 10px;
            border: 2px solid #1a2e69;   /* deep navy border */
            background-color: #0d47a1;   /* rich blue background */
            color: #ffffff;              /* white text */
            text-decoration: none;
            font-size: 1.5em;
            font-weight: bold;
            text-align: center;
            border-radius: 6px;          /* optional: smoother look */
        }

        #apply-now a {
            color: #ffffff;              /* white text */
            text-decoration: none;
            display: block;             
        }
        #apply-now:hover a{
            color: #1565c0;   /* slightly lighter blue on hover */
        }
    </style>
    <title>Job listings</title>
</head>

<body>
    <?php include 'extrafiles/header.inc'; 
    include 'extrafiles/nav.inc';
    ?>
<section id="job-listings-header">
    <h3>Job Listings</h3>
</section>

<section id="job-listings-text">
    <h3>Explore our list of currently offered Jobs below!</h3>
</section>

<form method="get" action="jobs.php" style="text-align:center; margin-bottom:20px;">
    <input type="text" name="search" id="search">
    <input type="submit" value="Search">
</form>

<?php
require_once "extrafiles/settings.php";

$conn = new mysqli($host, $user, $pwd, $sql_db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : ''; //get search query from URL, if it exists otherwise empty string

if ($search !== '') { //checks if search is empty if not searches if title or anything contains the searched term
    $search = $conn->real_escape_string($search);
    $query = "SELECT * FROM jobs_information 
              WHERE title LIKE '%$search%' 
              OR description LIKE '%$search%' 
              OR reporting_line LIKE '%$search%' 
              OR key_responsibilities LIKE '%$search%' 
              OR essential_requirements LIKE '%$search%'";
} else {
    $query = "SELECT * FROM jobs_information"; //if search empty diplsays all jobs
}
$result = $conn->query($query); //execute query and get result set

//display everything in the result set as set below
while ($job = $result->fetch_assoc()) { //loop through each job and display as set below
echo '
<section class="title-section">
    <h1>' . $job['title'] . '</h1>
    <h2>Ref Num: ' . $job['ref_num'] . '</h2>
    <h2 class="salary">Salary: $' . $job['salary_min'] . ' - $' . $job['salary_max'] . '</h2>
</section>

<section class="job-description">
    <h3>Description</h3>
    <p>' . $job['description'] . '</p>
</section>

<div class="job-info-flex-container">

    <section class="reporting-line">
        <h4>Reporting Line:</h4>
        <p>' . str_replace(";", "<br>", $job["reporting_line"]) . '</p>
    </section>

    <section class="key-responsibilities">
        <h4>Key Responsibilities</h4>
        <p>' . str_replace(";", "<br>", $job["key_responsibilities"]) . '</p>
    </section>

    <section class="essential-requirements">
        <h4>Essential Requirements</h4>
        <p>' . str_replace(";", "<br>", $job["essential_requirements"]) . '</p>
    </section>

</div>
';
}
$conn->close();
?>


<!--
    <section class="title-section">
        <h1>Chief Web Designer</h1>
        <h2>Ref Num: XcZ35</h2>
        <h2 class="salary">Salary: $100,000 - $120,000</h2>
    </section>
    <section class="job-description">
        <h3>Description</h3>
        <P>This job involves managing our Web design operations and tasks. Incuding our day to day operations in
            TechHive and the handling of customer orders.
            TechHive requires a chief web designer with technical expertise and experience as this job will require
            coordinating and leading a team of other web designers and Technical staff in order to deliver the best experience for
            our users.
        </P>
    </section>
<div class = "job-info-flex-container">
    <section class="reporting-line">
        <h4>Reporting Line:</h4>
        <ol>
            <li>Chief Financial Officer</li>
            <li>Chief Operating Officer</li>
            <li>Chief Executive Officer</li>
        </ol>
    </section>
    <section class="key-responsibilities">
        <h5>Key Responsibilities</h5>

        <ul title="Key Responsibilities">
            <li>Oversee the day-to-day operations of our educational platform TechHive.</li>
            <li>Coordinate and lead the team of web designers to ensure products are well advertised and delivered at the highest quality.</li>
            <li>Manage Implementation of new features into TechHive</li>
            <li>Oversee site performance and encourage continuous improvement.</li>
        </ul>
    </section>
    <section class="essential-requirements">
        <h5>Essential Requirements</h5>

        <ul>
            <li>3-5+ years of experience in Web design.</li>
            <li>Strong leadership and communication skills.</li>
            <li>Proficiency in EdTech platforms and tools such as Inkscape and Piktochart</li>
        </ul>
    </section>
</div>
    <section>
        <h1>Web Designer</h1>
        <h2>Ref Num:KMp35</h2>
        <h2 class="salary">Salary: $80,000 - $90,000</h2>
    </section>
    <section class="job-description">
        <h3>Description</h3>
        <P>This job involves organising our EdTech online educational services including designing and redesigning useful online educational tools. TechHive requires a Web Designer with experience in past educational tools as this job will require the candidate to have a good eye for detail and be able to innovate of past designs and be able to work with the Chief Web Designer to ensure
            that our products are well advertised and are delivered at our highest quality.
        </P>
    </section>
<div class = "job-info-flex-container">
    <section class="reporting-line">
        <h4>Reporting Line:</h4>
        <ol>
            <li>Chief Web Designer</li>
            <li>Chief Operating Officer</li>
            <li>Chief Executive Officer</li>
        </ol>
    </section>
    <section class="key-responsibilities">
        <h4>Key Responsibilities</h4>

        <ul title="Key Responsibilities">
            <li>Organise Educational product listings and manage the development of these products</li>
            <li>Coordinate with the Chief Web Designer to ensure products are well developed</li>
            <li>Research market data to identify which products are in demand and organise accordingly</li>
        </ul>
    </section>
    <section class="essential-requirements">
        <h5>Essential Requirements</h5>

        <ul>
            <li>1+ year of experience in Web design or related fields such as web development.</li>
            <li>Technical experience in website development with HTML and CSS</li>
            <li>Proficiency in EdTech platforms and tools such as Inkscape</li>
        </ul>
    </section>
</div>

    <section>

        <h1>Digital Learning Content Specialist</h1>
        <h2>Ref Num: YpT35</h2>
        <h2 class="salary">Salary: $50,000 - $60,000</h2>
    </section>
    <section class="job-description">
        <h3>Description</h3>
        <P>An opportunity to shape engaging, accessible digital learning experiences for a leading EdTech company. This role focuses on creating, curating, and optimising educational content that supports inclusive online learning for diverse audiences.        </P>
    </section>
<div class = "job-info-flex-container">  
    <section class="reporting-line">
        <h4>Reporting Line:</h4>
        <ol>
            <li>Head of Learning Experience Design</li>
            <li>Chief Web Designer</li>
            <li>Chief Operating Officer</li>
            <li>Chief Executive Officer</li>
        </ol>
    </section>
    <section class="key-responsibilities">
        <h4>Key Responsibilities</h4>

        <ul title="Key Responsibilities">
            <li>Analyse learner feedback and platform data to inform continuous content improvement.</li>
            <li>Review and refine existing learning modules to improve clarity, engagement, and learning outcomes.</li>
            <li>Collaborate with subject‑matter experts to translate complex concepts into clear, learner‑friendly materials.</li>
        </ul>
    </section>
    <section class="essential-requirements">
        <h4>Essential Requirements</h4>

        <ul>
            <li>5+ year of previous experience in learning experience design or a similar role</li>
            <li>Good social skills and the ability to communicate effectively with designers and developers</li>
            <li>Experience creating digital learning content, curriculum materials, or instructional resources. Provide examples of past work. </li>
        </ul>
</section>     
-->   
    </div>
    <div id="apply-now">
        <a href="apply.php" target="_self">Apply Now To Get a Great Opportunity!</a>
    </div>

    <aside><p>Avoid scams: no real employer charges interview or application fees.</p></aside>
    
    <?php include 'extrafiles/footer.inc'; ?>

</body>


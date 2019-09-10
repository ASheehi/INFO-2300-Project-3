<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "About";
?>
<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body style="padding-left: 160px;">
  <?php include('includes/header.php'); ?>
  <!-- TODO: This should be your About page for your site. -->
  <div class="row">
    <div class="column2 left" style="background-color:rgb(161, 0, 0); border-style: solid;">
      <h2>Contact Us</h2>
      <p>Anthony Sheehi: <a href="mailto:ajs636@cornell.edu">ajs636@cornell.edu</a></p>
    </div>
    <div class="column2 right" style="background-color: white;">
      <h2 style="color: rgb(161, 0, 0)">Who We Are</h2>
      <p style ="padding-bottom: 20px; color: black; padding-left: 40px; text-align: center;">CornelleScope impacts the CU college-life perspective by giving visual dedscriptions of buildings and landmarks around campus (and the opportunity for others to take beautiful photos of them too). Here, we promote Cornell's campus, and allowing people to see the beauty in our school. Prospective students will not be able to contribute, but they will be able to view the photos taken by students here.</p>
      <div id ="bios">
        <!-- Source: (original photo) Anthony Sheehi -->
        <img style="border-style: outset;" src="images/anthonyBio.jpg" alt="Anthony_Bio" height="200">
        <h1 style ="color: black;">Anthony Sheehi<h1>
        <h2>Hey guys! My name's Anthony Sheehi and I'm the developer and founder of CornelleScope. I am currently a freshman studying Computer Science in the College of Engineering (transferring to A&S soon though). I take pride in the fact that I have diverse interests and abilities. While I might seem like a complete computer geek at first, I'm actually really into sociology, cultures, and languages. I also really love music (and I sing and play my ukulele pretty often). I like to maintain a positive outlook in life and no matter what happens now I know that there's a lot more ahead of me. Look forward to the continously updated site! Enjoy, and don't forget to keep contributing!</h2>
        <p style ="padding-bottom: 40px;"> </p>
      </div>
    </div>
  </div>

  <?php include("includes/footer.php"); ?>
</body>
</html>

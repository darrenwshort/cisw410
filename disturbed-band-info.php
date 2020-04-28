<?php
$band = "disturbed";
$title = ucfirst($band);
include('header.php');
?>

<main>
<section class="bandinfo">
<h1><?php echo "$band"; ?></h1>
<a target="_blank" href="https://www.disturbed1.com/">
 <?php echo '<img class="band-img" src="images/' . $band . '-img.jpg" alt="' . $band . '-band-img" align="right">'; ?>
</a>

<article class="band-article">
<p>
A hard-hitting, multi-platinum-selling heavy metal outfit based out of Chicago, Disturbed emerged in the late '90s with an aggressive blend of hard rock and alternative and nu metal. Fortified by a distinct melodic complexity and the uncompromising swagger of frontman David Draiman, the band exploded onto the scene in 2000 with The Sickness, which peaked at number 29 on the Billboard 200 and was eventually certified five-times platinum. They broke huge in 2002 with their sophomore effort, Believe, which, like all four of their subsequent offerings, debuted at number one. Disturbed went on a four-year hiatus in 2011 to focus on various side projects, but returned in 2015 with the chart-topping Immortalized, confirming their status as one of the genre's most commercially successful acts.
</p>
<p>
Disturbed came together through the matching of a band with a singer. Longtime friends Dan Donegan (guitar), Mike Wengren (drums), and Fuzz (bass) played together in Chicago for some time before hooking up with singer David Draiman around 1997. Draiman had grown up in a religious family against which he rebelled, being expelled from five boarding schools in his adolescence. His anger found an outlet in the thrashing sound of Disturbed, who built up a following on Chicago's South Side before a demo tape led to their signing to Giant Records, which released their debut album, The Sickness, in March 2000. Disturbed gained more fans and exposure playing the main stage of the 2001 Ozzfest, then broke away to do their own self-described "victory lap" around the U.S. that fall. Also during this period, they managed to record a vicious new version of wrestler Steve Austin's theme song that was so good it managed to receive radio play, and they were one of the bands announced to work on a high-profile Faith No More tribute album.
</p>
<p>
  <cite class="artist-cite">Artist Biography Source: <a target="_blank" href="https://www.allmusic.com/artist/disturbed-mn0000175579/biography">Read More...</a></cite>    
</p>
</article>
</section>
</main>

<?php
include('footer.php')
?>

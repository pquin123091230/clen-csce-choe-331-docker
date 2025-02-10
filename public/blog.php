<html>
    <body>
        <h1>Blog.php</h1>
        <a href="index.php">BACK</a>

<?php
class blogPost {

    public function __construct($title, $text, $date) {
        $this->title = $title;
        $this->text = $text;
        $this->date = $date;
    }
    public $title = "";
    public $text = "";
    public $date = "";

}

$blogPosts = array();
array_push($blogPosts, new blogPost("Post 1, Project 1", "
<b>Introduction</b><br>
Hello, my name is Patrick 
Quinn and I am a 3rd year Computer Science major at Texas A&M university. In this blog I will cover my previous development experience, how I made this site, and lessons I took from that making. <br><br>
<b>Previous Development Experience</b><br>
    I have worked with many languages for years across my combined software development experience. Like many, I started with scripting languages when I was barely a teenager and became interested in making automated machines to accomplish tasks on my PC while I was away. Over time, the experience I gained from that encouraged me to engage with more complex and difficult languages, until one summer I decided to attempt to build a video game using Unreal Engine. While I did not succeed, I also did not give up and next summer I restarted the project and actually succeeded. In university, I have worked with Python, Haskell, Java, C++, and others, and although this did not contribute significantly to my programming ability (I do not consider college assignments to be meaningful applications of programming expertise) I also have the benefit of having undergone an internship last summer for Lockheed Martin. In that internship I used many tools and languages including C++, Python, HTML, CSS, JavaScript, SQL, Docker, and MatLab. Considering all of this I consider myself very experienced in software development for my age, but I am always learning, so I am now working on greater projects, like a sequel to the game I made 2 years ago.<br><br>

<b>Development Process</b><br>
    The Development process of this php website was not very difficult to deal with as the steps for creating the website were pretty much laid out to us in the directions of the assignment. The only real planning needed was to determine when and where to work on it, and what exactly my implementation of the desired objectives would look like. To that end, I use my normal method, which involves iteratively building the implementation and then refining it or improving it as needed. In my experience this reduces the amount of bug fixing needed as you find problems early when the base of untested code is small, and therefore can focus on individual pieces of code to fix instead of needing to debug an entire system. This was especially necessary during part 1, where the recommended course of action proved to be undesirable, as the use of the text manipulation language was not practical for the task. Instead I iterated over the content of the csv file to process and use data variables to understand the context of the operations, thus saving a lot of time, both on part 1 and part 2. <br><br>
\tAs for part 2, in turned out the internal mechanism for the csv file processor and markdown processor were very similar, and as a result I essentially copied and modified the system I used for part 1 to tolerate a much larger variation in contexts (headers, lists, images etc.) using different key characters. Because I had used a more general purpose algorithm for part 1, I was able to complete part 2 far more quickly as well as saving valuable debugging time as a large portion of the low level code was reused and therefore already debugged. One issue I did face for part 2 was dealing with nested lists. In order to solve this problem, I began treating lists as an integer instead of a Boolean, allowing for the integer to be incremented by one every time a list was entered and decremented every time a list was exited. This worked so well that, with only a few modifications, it would have been able to work with any quantity of nested lists in addition to the required 2, but as I was on a time crunch I decided not to spend my time pursuing exceeded requirements. <br><br>
\tPart 3, the image gallery, continued the theme of similar back end code, as the process of reading the names and descriptions of the images was nearly identical to part 1, and so yet again the code was reused in order to create the gallery. However, the gallery presented its own set of challenges as it became apparent that the structure of the docker container was slightly different to that of my computer, and this caused undefined behavior when attempting to load images outside of the main directory. As a result, I had to move the images to the main directory, or use images I found online to test the gallery system, but I found that it worked when that restriction was applied. Interestingly enough, the sorting and display aspects of the gallery were much easier, as it is possible to define weights for the images using a structure and sort by those weights, where the weights are defined by the sort mode desired. The display modes, while requiring hard coding for each one were not very complicated as the images in question were already defined as a list and so it was possible to iterate through them and echo html in order to wrap it in a certain display structure.<br><br>
<b>Lessons Learned</b><br>
\tI have been involved in the development of many projects, many far larger than this one, so I cannot say that this assignment fostered any breakthroughs for me. However I did learn about the power of the php language and how it can be used to speed up the creation of websites. In the past, I used python and Flask in order to create websites similar to this one, however that api has a few problems in terms of quickness. For example, in order to obtain the value of a variable from python, a complex set of operations need to be undergone, including a GET request, creation of a pipeline on the webpage and a JavaScript function to handle it. From what I can see of php, it would be possible to streamline the process significantly. I cannot say honestly that I liked any aspect of this project, because it was tedious and boring, but if there was something I had to pick as my least disliked aspect it would be the learning of php, as I like the language. The part of the project I found least useful was the search algorithm, as it did not really teach anything and didn’t even accomplish anything interesting designed to the specifications required in the project. Although I will say I could’ve done better on the design of the mark down part of the project, by putting it on a different page with a link instead of displaying on the main page. In addition, I did not put much consideration into styling/presentation as it was not part of the assignment, however my biggest defficiency at the moment in my professional skillset is presentation ability, as I find it difficult to communicate information to users through the design and presentation of products I design. <br><br>
<b>Conclusion</b><br>
\tIn conclusion, I have a lot of experience with larger projects than this one, and as a result am already familiar with many of the problems associated with large development projects. Still, I learned a fair bit from this project about certain specifics of web development, which will be helpful as web development is an important part of the software engineering industry. <br><br>
<b>References</b><br>

<ol>
    <li>Stack Overflow, “Stack Overflow - Where Developers Learn, Share, & Build Careers,” Stack Overflow, 2024. <a href=\"https://stackoverflow.com\">https://stackoverflow.com</a></li>
    ‌<li>W3Schools, “W3Schools online web tutorials,” W3schools.com, 1999. <a href=\"https://www.w3schools.com\">https://www.w3schools.com</a></li>
    <li>The PHP Group, “PHP: Hypertext Preprocessor,” Php.net, Apr. 04, 2019. <a href=\"https://www.php.net\">https://www.php.net</a></li>
‌
‌</ol>

", "2/10/25"));

foreach ($blogPosts as $blogPost) {
    echo "<h2>".$blogPost->title." - ".$blogPost->date."</h2>";
    echo "Word Count: ".str_word_count($blogPost->text)."<br><br>";
    echo $blogPost->text;
}
?>

</body>
</html>
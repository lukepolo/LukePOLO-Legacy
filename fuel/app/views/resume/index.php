<?php
if (strtolower(Agent::browser()) == 'chrome')
{
?>
    <div style="height: 1100px;" id="pdf">
        
    </div>
    <?php
        echo Asset::js('pdfobject.js');
    ?>
    
    <script type='text/javascript'>
        window.onload = function (){
          var myPDF = new PDFObject({ url: "https://dl.dropbox.com/u/20485770/Luke_Policinski_Resume.pdf"}).embed('pdf');
        };
    </script>
<?php
}
else
{
?>
    <div id="resume">
        <iframe src="https://docs.google.com/viewer?url=https%3A%2F%2Fdl.dropbox.com%2Fu%2F20485770%2FLuke_Policinski_Resume.pdf&embedded=true" width="100%" height="1080" style="border: none;"></iframe>
    </div>

<?php
}
?>


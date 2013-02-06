<div style="height: 1200px;" id="pdf">
    
</div>
<?php
    echo Asset::js('pdfobject.js');
?>

<script type='text/javascript'>
    window.onload = function (){
      var myPDF = new PDFObject({ url: "https://dl.dropbox.com/u/20485770/Luke_Policinski_Resume.pdf"}).embed('pdf');
    };
</script>
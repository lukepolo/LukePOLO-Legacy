<script type="text/javascript">
    $(document).ready(function()
    {
	$('textarea').markItUp(mySettings);
	
	$('textarea').keyup(new_text);
	$('textarea').change(new_text);
	$('textarea').keyup();
	
    });
    
    function new_text()
    {
	text = $(this).val();
	$('#live').html(text).text();
    };
    
</script>
<?php
    echo Form::open();
?>
    <p>Title</p>
        <?php
            echo Form::input('title',empty($blog) === false ? $blog->title : '',array('required'=>'required'));
        ?>
        <p>Sub Title</p>
        <?php
            echo Form::input('sub_title',empty($blog) === false ? $blog->sub_title : '',array('required'=>'required'));
        ?>
        <p>Slug</p>
        <?php
            echo Form::input('slug',empty($blog) === false ? $blog->slug : '',array('required'=>'required'));
        ?>
        <p>Blog</p>
        <?php
            echo Form::textarea('text',empty($blog) === false ? Markdown::parse($blog->text) : '',array('class'=>'editable','rows'=>'10','required'=>'required','style'=> 'width:100%;'));
        ?>
        <br>
        <?php
        echo Form::submit('submit',empty($blog) === false ? 'Update' : 'Create'.' Blog',array('class' => 'btn btn-primary'));
    echo Form::close();
    ?>
    
    <div id="live"></div>
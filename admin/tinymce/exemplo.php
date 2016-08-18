<!DOCTYPE html>
<html>
<head>
</head>
<body>
<script src="tinymce/tinymce.min.js">

</script>



<textarea name="texto" id="texto" >

</textarea>

	</body>
	
	
	<script>

tinymce.init({
	
	language : 'pt_BR',
    selector: "#texto",theme: "modern",width: 680,height: 300,
	
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen textcolor",
		"insertdatetime media table contextmenu paste jbimages responsivefilemanager"
		],
	
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| jbimages | responsivefilemanager |  link unlink anchor | image media | forecolor backcolor  | print preview code ",
   image_advtab: true ,
   
   
   external_filemanager_path:"/editor_html/tinymce_latest_custom/tinymce/responsive_filemanager/filemanager/",
   filemanager_title:"Gerenciar Arquivos" ,
   external_plugins: { "filemanager" : "/editor_html/tinymce_latest_custom/tinymce/plugins/responsivefilemanager/plugin.min.js"}
 });
 
</script>
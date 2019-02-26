<!DOCTYPE html>
<html>
<head>
	<title>Todo List By Ajax</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6">
				<div class="panel panel-default" >
					<div class="panel-heading">
						<h3 class="panel-title"id="addNew" >Panel Title <a href="" class="pull-right" data-toggle="modal" data-target="#myModal"> <i class="fas fa-plus" aria-hidden="true"></i></a></h3>
					</div>
						<div class="panel-body" id="items">
							
							<ul class="list-group">
								@foreach($items as $item)
							  <li class="list-group-item ouritem" data-toggle="modal" data-target="#myModal">{{$item->item}}
							  	<input type="hidden" id="itemId" value="{{$item->id}}" name="">
							  </li>
							  
							 @endforeach
							</ul>
							
						</div>
					
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-2">
		<input type="text" id="searchItem" class="form-control" placeholder="search item" name="searchItem">
	</div>

	<div class="modal" tabindex="-1" role="dialog"  id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Add New Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="id">
        <input type="text" class="form-control" id="additem" placeholder="type text here" name="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete" style="display: none;">Delete</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="saveChanges" style="display: none">Save changes</button>
        <button type="button" class="btn btn-primary" id="addButton" data-dismiss="modal">Add Button</button>
      </div>
    </div>
  </div>
</div>



{{csrf_field()}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function() {


		$(document).on('click','.ouritem',function(event) {
			

				var id = $(this).find('#itemId').val();
				var text = $(this).text();
				$('#title').text('Edit');
				$('#delete').show(400);
				$('#saveChanges').show();
				var text = $.trim(text);
				$('#additem').val(text);
				$('#addButton').hide();
				$('#id').val(id);

				//console.log(text);
			});
		


			$(document).on('click','#addNew',function(event) {
				
				$('#title').text('Add New Item');
				$('#delete').hide(400);
				$('#saveChanges').hide();
				$('#additem').val('');
				$('#addButton').show(400);

				
			});


			$(document).on('click','#addButton',function(event) {
				
				var text = $('#additem').val();
				if(text=="")
					alert("please write something");
				else{
					$.post('list', {'text':text,'_token':$('input[name=_token]').val()}, function(data) {
					console.log(data);
					$('#items').load(location.href + ' #items');
				});
				}
				
			});


			$('#delete').click(function(event) {
				var id = $('#id').val();
				$.post('delete', {'id': id,'_token':$('input[name=_token]').val()}, function(data) {
					console.log(data);
					$('#items').load(location.href + ' #items');
					
				});
				
			});


			//update item
			$(document).on('click','#saveChanges',function(event) {
				
				var value = $('#additem').val();
				var id = $('#id').val();
				
				$.post('update', {'id':id,'text': value,'_token':$('input[name=_token]').val()}, function(data) {
					console.log(data);
					$('#items').load(location.href + ' #items');
					
				});
				
			});





	});

	 $( function() {
    
    $( "#searchItem" ).autocomplete({
      source: 'http://127.0.0.1:8000/search'
    });
  } );
</script>
</body>
</html>
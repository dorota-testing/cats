@extends('layouts.app')

@section('content')
        <div class="col-md-10">	
			<h1>{{str_plural($url)}} <?=($strParent!='' ? ' of '.$strParent : '')?> 
			
			@if($table['add'])
			<a href="{{ route('/') }}/{{ $url }}/<?=($id!='' ? $id.'/' : '')?>0" class="btn btn-warning pull-right">Add {{$url}}</a>
			@endif	
			@if(!empty($table['parent']))
			<a href="{{ route('/') }}/select/{{ $table['parent'][0] }}" class="btn btn-warning pull-right">Back to {{str_plural($table['parent'][0])}}</a>
			@endif				
			<?php 
//			dump( $id);
			?>
			</h1>
			<!--<pre>{{print_r($table)}}</pre>-->
			<!--<pre>{{var_dump($content)}}</pre>-->
			@if(!empty($content))
				<div class="table">
				<div class="table-row">
					@foreach($table['titles'] as $title)
					<span class="cell th">{{ $title }}</span>
					@endforeach	
					@if($table['edit'] || $table['delete'] || !empty($table['buttons']))
						<span class="cell th options">Options</span>					
					@endif						
				</div>
				@foreach($content as $row)
				<div class="table-row">
					<?php if ($url == 'Cat'){?>
					
					<span class="cell td"><?php echo $row->name ?></span>						
					<span class="cell td"><?php echo $row->gender ?></span>						
					<span class="cell td"><?php echo $row->breed->breed ?></span>						
					<?php } else {
					foreach($table['fields'] as $field) {
						$lorem = $row->$field;
					?>					
					<span class="cell td"><?php echo $lorem ?></span>

					<?php } }?>
					
					@if($table['edit'] || $table['delete'] || !empty($table['buttons']))
					<span class="cell td options">
						<?php if(!empty($table['buttons'])) {
							foreach($table['buttons'] as $link=>$name){
							$itemCount = $row->$name()->count();
						?>
							<a href="{{ route('/') }}/select/{{ $link }}/{{ $row->id }}" class="btn btn-warning">{{ ucfirst($name) }} ({{ $itemCount }})</a>
						<?php }
						} 
						?>
						@if($table['edit'])
						<a href="{{ route('/') }}/{{ $url }}/<?=($id!='' ? $id.'/' : '')?>{{ $row->id }}" class="btn btn-primary"> Edit</a>
						@endif
						@if($table['delete'])
							@if(Auth::user()->user_role=='admin')
						<a href="{{ route('/') }}/delete/{{ $url }}/{{ $row->id }}" class="btn btn-danger" onclick="return  confirm('Are you sure you want to Delete?')">Delete</a>
							@else
						<span class="btn btn-default hoverTip">Delete</span>
							@endif
						@endif
					</span>
					@endif	
				</div>
				@endforeach
				</div>
			@endif			
        </div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
</head>
<body>
    @extends('layouts.app')
    
    @section('content')
    <div class="container">
        @if($errors->any())
        <div class="alert alert-warning">
            <ol>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ol>
        </div> 
        @endif
        
        <form action="{{ route('articles.update', $data['id']) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $data['title']) }}" class="form-control">
            </div>
            
            <div class="mb-3">
                <label>Body</label>
                <textarea name="body" class="form-control">{{ old('body', $data['body']) }}</textarea>
            </div>
            
            <div class="mb-3">
                <label>Category</label>
                <select class="form-select" name="category_id">
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}" @if($category['id'] == old('category_id', $data['category_id'])) selected @endif>{{ $category['name'] }}</option>
                @endforeach
                </select>
            </div>
            
            <input type="submit" value="Update" 
            class="btn btn-primary">
        </form>
    </div>
    @endsection
</body>
</html>
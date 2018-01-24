@extends('admin.layout')

  @section('page_header')
    Dashboard {{ 
      Route::getCurrentRoute()->uri()
    }}
  @stop

  @section('content')
    <h1>Mostrar todas las publicaciones</h1>
  @stop

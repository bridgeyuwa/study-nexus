@extends('errors::backend')

@section('title', __('Internal Server Error'))
@section('code', '500')
@section('message', __('We are sorry but there was an issue with our server and couldn’t fulfill your request.'))

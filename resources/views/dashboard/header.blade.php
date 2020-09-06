<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Adminto - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="icon" type="image/x-icon"  href="{{asset('admin/images/favicon.ico')}}">

    <!--Morris Chart-->
    <link rel="stylesheet"  href="{{asset('admin/libs/morris-js/morris.css')}}" />



    <!-- App css -->
    <link   href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />


    <link  href="{{asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link  href="{{asset('admin/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />


    @yield('styles')



    <style>

        @media print{
            table, th, td
            {
                border-collapse:collapse;
                border: 1px solid black;
                width:100%;
                text-align:right !important;
            }
            body{
                float: right;
                text-align: right;
            }
            th{
                float: right;
            }
            tr{
                float: right;
            }
            td{
                float: right;
                text-align: right;
            }
            table{
                float: right;
                text-align: right;
            }
        }
        /* width */
::-webkit-scrollbar {
    width: 7px;
  }
  
  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f100; 
  }
   
  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #f1f1f1; 
  }
  
  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #8080807a; 
  }
    </style>
</head>
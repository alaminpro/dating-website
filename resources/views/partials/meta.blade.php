<?php
    $seo_website_title = setting('website_title');
    $seo_website_description = setting('website_description');
    $seo_website_tagline = setting('website_tagline');
    $seo_website_keywords = setting('website_keywords');
    $seo_social_image = setting('social_image');
    $seo_website_type = 'website';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=1.0, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta name="csrf_token" content="{!! csrf_token() !!}">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title> {!! isset($seo_title) ? $seo_title.' | '.$seo_website_title : $seo_website_title !!} @yield('page_title')</title>
<meta name="keywords" content="{!! isset($seo_keywords) ? $seo_keywords.','.$seo_website_keywords : $seo_website_keywords !!}">
<meta name="description" content="@yield('page_description')">
<meta property="og:title" content="@yield('page_title') {!! isset($seo_title) ? $seo_title.' - '.$seo_website_title : $seo_website_title !!}">
<meta property="og:type" content="{!! isset($seo_type) ? $seo_type: $seo_website_type !!}">
<meta property="og:url" content="{!! request()->url !!}">
{{-- <meta property="og:image" content="@yield('social_image')"> --}}
<meta property="og:site_name" content="{!! $seo_website_tagline !!}">
<meta property="og:description" content="@yield('page_description')"> 
<meta property="og:image" content="http://datev2.com/uploads/sites/90Q4K2tVoSVRqOTSG9dh.jpg">
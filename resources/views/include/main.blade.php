<!DOCTYPE html>
<html lang="en">
<head>
	@include('include.header')
</head>
<body > 
        <!-- TITLE and NAVIGATION SECTION -->    
        @include('include.common')

        <!-- MAIN CONTENT SECTION -->
        @yield('content')

        <!-- Footer SECTION -->
        @include('include.footer')
        <!-- Page owned javascript or file linking SECTION -->
        @yield('user_js')        
</body>
</html>
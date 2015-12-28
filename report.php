<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>NeXt FaX - Dashboard</title>


    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.min.css" media="all">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body class=" sidebar_main_open sidebar_main_swipe">
   <!-- main header -->
	<?php include_once('includes/header.php'); ?>
	<!-- main header end -->
	<!-- main sidebar -->
	<?php include_once('includes/sidemenu.php'); ?>
	<!-- main sidebar end -->

<div id="page_content">
    <div id="page_content_inner">
<div class="uk-width-large-8-10 uk-container-center">
        <h3 class="heading_b uk-margin-bottom">Fax Reports</h3>

        <div class="md-card">
            
            <div class="md-card-content">
                    <div class="uk-overflow-container uk-margin-bottom">
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="ts_checkbox_all"></th>
                                <th class="filter-false remove sorter-false">Image</th>
                                <th>Name</th>
                                <th>Major</th>
                                <th>Sex</th>
                                <th>English</th>
                                <th>Japanese</th>
                                <th>Calculus</th>
                                <th>Geometry</th>
                                <th class="filter-false remove sorter-false uk-text-center">Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Major</th>
                                    <th>Sex</th>
                                    <th>English</th>
                                    <th>Japanese</th>
                                    <th>Calculus</th>
                                    <th>Geometry</th>
                                    <th class="uk-text-center">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_08_tn.png" alt=""/></td>
                                <td>Student01</td>
                                <td>Languages</td>
                                <td>male</td>
                                <td>80</td>
                                <td>70</td>
                                <td>75</td>
                                <td>80</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_04_tn.png" alt=""/></td>
                                <td>Student02</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>90</td>
                                <td>88</td>
                                <td>100</td>
                                <td>90</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_04_tn.png" alt=""/></td>
                                <td>Student03</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>85</td>
                                <td>95</td>
                                <td>80</td>
                                <td>85</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_06_tn.png" alt=""/></td>
                                <td>Student04</td>
                                <td>Languages</td>
                                <td>male</td>
                                <td>60</td>
                                <td>55</td>
                                <td>100</td>
                                <td>100</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_04_tn.png" alt=""/></td>
                                <td>Student05</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>68</td>
                                <td>80</td>
                                <td>95</td>
                                <td>80</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_01_tn.png" alt=""/></td>
                                <td>Student06</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>100</td>
                                <td>99</td>
                                <td>100</td>
                                <td>90</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_01_tn.png" alt=""/></td>
                                <td>Student07</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>85</td>
                                <td>68</td>
                                <td>90</td>
                                <td>90</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_01_tn.png" alt=""/></td>
                                <td>Student08</td>
                                <td>Languages</td>
                                <td>male</td>
                                <td>100</td>
                                <td>90</td>
                                <td>90</td>
                                <td>85</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_06_tn.png" alt=""/></td>
                                <td>Student09</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>80</td>
                                <td>50</td>
                                <td>65</td>
                                <td>75</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_10_tn.png" alt=""/></td>
                                <td>Student10</td>
                                <td>Languages</td>
                                <td>male</td>
                                <td>85</td>
                                <td>100</td>
                                <td>100</td>
                                <td>90</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_01_tn.png" alt=""/></td>
                                <td>Student11</td>
                                <td>Languages</td>
                                <td>male</td>
                                <td>86</td>
                                <td>85</td>
                                <td>100</td>
                                <td>100</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_04_tn.png" alt=""/></td>
                                <td>Student12</td>
                                <td>Mathematics</td>
                                <td>female</td>
                                <td>100</td>
                                <td>75</td>
                                <td>70</td>
                                <td>85</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_01_tn.png" alt=""/></td>
                                <td>Student13</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>100</td>
                                <td>80</td>
                                <td>100</td>
                                <td>90</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_01_tn.png" alt=""/></td>
                                <td>Student14</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>50</td>
                                <td>45</td>
                                <td>55</td>
                                <td>90</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_03_tn.png" alt=""/></td>
                                <td>Student15</td>
                                <td>Languages</td>
                                <td>male</td>
                                <td>95</td>
                                <td>35</td>
                                <td>100</td>
                                <td>90</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_06_tn.png" alt=""/></td>
                                <td>Student16</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>100</td>
                                <td>50</td>
                                <td>30</td>
                                <td>70</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_11_tn.png" alt=""/></td>
                                <td>Student17</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>80</td>
                                <td>100</td>
                                <td>55</td>
                                <td>65</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_05_tn.png" alt=""/></td>
                                <td>Student18</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>30</td>
                                <td>49</td>
                                <td>55</td>
                                <td>75</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_09_tn.png" alt=""/></td>
                                <td>Student19</td>
                                <td>Languages</td>
                                <td>male</td>
                                <td>68</td>
                                <td>90</td>
                                <td>88</td>
                                <td>70</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_02_tn.png" alt=""/></td>
                                <td>Student20</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>40</td>
                                <td>45</td>
                                <td>40</td>
                                <td>80</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_12_tn.png" alt=""/></td>
                                <td>Student21</td>
                                <td>Languages</td>
                                <td>male</td>
                                <td>50</td>
                                <td>45</td>
                                <td>100</td>
                                <td>100</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_03_tn.png" alt=""/></td>
                                <td>Student22</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>100</td>
                                <td>99</td>
                                <td>100</td>
                                <td>90</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_04_tn.png" alt=""/></td>
                                <td>Student23</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>82</td>
                                <td>77</td>
                                <td>0</td>
                                <td>79</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_06_tn.png" alt=""/></td>
                                <td>Student24</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>100</td>
                                <td>91</td>
                                <td>13</td>
                                <td>82</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_10_tn.png" alt=""/></td>
                                <td>Student25</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>22</td>
                                <td>96</td>
                                <td>82</td>
                                <td>53</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_01_tn.png" alt=""/></td>
                                <td>Student26</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>37</td>
                                <td>29</td>
                                <td>56</td>
                                <td>59</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_03_tn.png" alt=""/></td>
                                <td>Student27</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>86</td>
                                <td>82</td>
                                <td>69</td>
                                <td>23</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_08_tn.png" alt=""/></td>
                                <td>Student28</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>44</td>
                                <td>25</td>
                                <td>43</td>
                                <td>1</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_12_tn.png" alt=""/></td>
                                <td>Student29</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>77</td>
                                <td>47</td>
                                <td>22</td>
                                <td>38</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_01_tn.png" alt=""/></td>
                                <td>Student30</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>19</td>
                                <td>35</td>
                                <td>23</td>
                                <td>10</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_08_tn.png" alt=""/></td>
                                <td>Student31</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>90</td>
                                <td>27</td>
                                <td>17</td>
                                <td>50</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_08_tn.png" alt=""/></td>
                                <td>Student32</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>60</td>
                                <td>75</td>
                                <td>33</td>
                                <td>38</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_05_tn.png" alt=""/></td>
                                <td>Student33</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>4</td>
                                <td>31</td>
                                <td>37</td>
                                <td>15</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_11_tn.png" alt=""/></td>
                                <td>Student34</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>77</td>
                                <td>97</td>
                                <td>81</td>
                                <td>44</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_01_tn.png" alt=""/></td>
                                <td>Student35</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>5</td>
                                <td>81</td>
                                <td>51</td>
                                <td>95</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_09_tn.png" alt=""/></td>
                                <td>Student36</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>70</td>
                                <td>61</td>
                                <td>70</td>
                                <td>94</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_12_tn.png" alt=""/></td>
                                <td>Student37</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>60</td>
                                <td>3</td>
                                <td>61</td>
                                <td>84</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_02_tn.png" alt=""/></td>
                                <td>Student38</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>63</td>
                                <td>39</td>
                                <td>0</td>
                                <td>11</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_09_tn.png" alt=""/></td>
                                <td>Student39</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>50</td>
                                <td>46</td>
                                <td>32</td>
                                <td>38</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_06_tn.png" alt=""/></td>
                                <td>Student40</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>51</td>
                                <td>75</td>
                                <td>25</td>
                                <td>3</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_11_tn.png" alt=""/></td>
                                <td>Student41</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>43</td>
                                <td>34</td>
                                <td>28</td>
                                <td>78</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_10_tn.png" alt=""/></td>
                                <td>Student42</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>11</td>
                                <td>89</td>
                                <td>60</td>
                                <td>95</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_10_tn.png" alt=""/></td>
                                <td>Student43</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>48</td>
                                <td>92</td>
                                <td>18</td>
                                <td>88</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_12_tn.png" alt=""/></td>
                                <td>Student44</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>82</td>
                                <td>2</td>
                                <td>59</td>
                                <td>73</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_10_tn.png" alt=""/></td>
                                <td>Student45</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>91</td>
                                <td>73</td>
                                <td>37</td>
                                <td>39</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_12_tn.png" alt=""/></td>
                                <td>Student46</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>4</td>
                                <td>8</td>
                                <td>12</td>
                                <td>10</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_05_tn.png" alt=""/></td>
                                <td>Student47</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>89</td>
                                <td>10</td>
                                <td>6</td>
                                <td>11</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_08_tn.png" alt=""/></td>
                                <td>Student48</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>90</td>
                                <td>32</td>
                                <td>21</td>
                                <td>18</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_05_tn.png" alt=""/></td>
                                <td>Student49</td>
                                <td>Mathematics</td>
                                <td>male</td>
                                <td>42</td>
                                <td>49</td>
                                <td>49</td>
                                <td>72</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                <td><img class="md-user-image" src="assets/img/avatars/avatar_02_tn.png" alt=""/></td>
                                <td>Student50</td>
                                <td>Languages</td>
                                <td>female</td>
                                <td>56</td>
                                <td>37</td>
                                <td>67</td>
                                <td>54</td>
                                <td class="uk-text-center">
                                    <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <ul class="uk-pagination ts_pager">
                        <li data-uk-tooltip title="Select Page">
                            <select class="ts_gotoPage ts_selectize"></select>
                        </li>
                        <li class="first"><a href="javascript:void(0)"><i class="uk-icon-angle-double-left"></i></a></li>
                        <li class="prev"><a href="javascript:void(0)"><i class="uk-icon-angle-left"></i></a></li>
                        <li><span class="pagedisplay"></span></li>
                        <li class="next"><a href="javascript:void(0)"><i class="uk-icon-angle-right"></i></a></li>
                        <li class="last"><a href="javascript:void(0)"><i class="uk-icon-angle-double-right"></i></a></li>
                        <li data-uk-tooltip title="Page Size">
                            <select class="pagesize ts_selectize">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </li>
                    </ul>
                </div>
            
            
        </div>

    </div>
    
    </div>
</div>

    <!-- google web fonts -->
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>


    <script>
        $(function() {
            // enable hires images
            altair_helpers.retina_images();
            // fastClick (touch devices)
            if(Modernizr.touch) {
                FastClick.attach(document.body);
            }
        });
    </script>


    <div id="style_switcher">
        <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
        <div class="uk-margin-medium-bottom">
            <h4 class="heading_c uk-margin-bottom">Colors</h4>
            <ul class="switcher_app_themes" id="theme_switcher">
                <li class="app_style_default active_theme" data-app-theme="">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_a" data-app-theme="app_theme_a">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_b" data-app-theme="app_theme_b">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_c" data-app-theme="app_theme_c">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_d" data-app-theme="app_theme_d">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_e" data-app-theme="app_theme_e">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_f" data-app-theme="app_theme_f">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_g" data-app-theme="app_theme_g">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
            </ul>
        </div>
        <div class="uk-visible-large uk-margin-medium-bottom">
            <h4 class="heading_c">Sidebar</h4>
            <p>
                <input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck />
                <label for="style_sidebar_mini" class="inline-label">Mini Sidebar</label>
            </p>
        </div>
        <div class="uk-visible-large">
            <h4 class="heading_c">Layout</h4>
            <p>
                <input type="checkbox" name="style_layout_boxed" id="style_layout_boxed" data-md-icheck />
                <label for="style_layout_boxed" class="inline-label">Boxed layout</label>
            </p>
        </div>
    </div>

    <!-- page specific plugins -->
    <!-- tablesorter -->
    <script src="bower_components/tablesorter/dist/js/jquery.tablesorter.min.js"></script>
    <script src="bower_components/tablesorter/dist/js/jquery.tablesorter.widgets.min.js"></script>
    <script src="bower_components/tablesorter/dist/js/widgets/widget-alignChar.min.js"></script>
    <script src="bower_components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js"></script>

    <!--  tablesorter functions -->
    <script src="assets/js/pages/plugins_tablesorter.min.js"></script>
    
    <script>
        $(function() {
            // enable hires images
            altair_helpers.retina_images();
            // fastClick (touch devices)
            if(Modernizr.touch) {
                FastClick.attach(document.body);
            }
        });
    </script>
    <script>
        $(function() {
            var $switcher = $('#style_switcher'),
                $switcher_toggle = $('#style_switcher_toggle'),
                $theme_switcher = $('#theme_switcher'),
                $mini_sidebar_toggle = $('#style_sidebar_mini'),
                $boxed_layout_toggle = $('#style_layout_boxed'),
                $body = $('body');


            $switcher_toggle.click(function(e) {
                e.preventDefault();
                $switcher.toggleClass('switcher_active');
            });

            $theme_switcher.children('li').click(function(e) {
                e.preventDefault();
                var $this = $(this),
                    this_theme = $this.attr('data-app-theme');

                $theme_switcher.children('li').removeClass('active_theme');
                $(this).addClass('active_theme');
                $body
                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g')
                    .addClass(this_theme);

                if(this_theme == '') {
                    localStorage.removeItem('altair_theme');
                } else {
                    localStorage.setItem("altair_theme", this_theme);
                }

            });

            // hide style switcher
            $document.on('click keyup', function(e) {
                if( $switcher.hasClass('switcher_active') ) {
                    if (
                        ( !$(e.target).closest($switcher).length )
                        || ( e.keyCode == 27 )
                    ) {
                        $switcher.removeClass('switcher_active');
                    }
                }
            });

            // get theme from local storage
            if(localStorage.getItem("altair_theme") !== null) {
                $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();
            }


        // toggle mini sidebar

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
                $mini_sidebar_toggle.iCheck('check');
            }

            $mini_sidebar_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_sidebar_mini", '1');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_sidebar_mini');
                    location.reload(true);
                });


        // toggle boxed layout

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
                $boxed_layout_toggle.iCheck('check');
                $body.addClass('boxed_layout');
                $(window).resize();
            }

            // toggle mini sidebar
            $boxed_layout_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_layout", 'boxed');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_layout');
                    location.reload(true);
                });


        });
    </script>
</body>
</html>
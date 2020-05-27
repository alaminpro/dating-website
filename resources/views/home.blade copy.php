<?php
if (isset($_COOKIE["USER"])) {
    header("location:index.php");
} else {
    include_once "pages/header.php";?>


    <!-- Header End -->


    <!-- Page Title -->


    <section id="page-title" class="page-title">


        <div class="container">


            <!-- THEME DEBUG -->


            <!-- THEME HOOK: 'region' -->


            <!-- FILE NAME SUGGESTIONS:


               * region--page-title.html.twig


               x region.html.twig


            -->


            <!-- BEGIN OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


            <div class="region region-page-title">


                <!-- THEME DEBUG -->


                <!-- THEME HOOK: 'block' -->


                <!-- FILE NAME SUGGESTIONS:


                   * block--pana-page-title.html.twig


                   * block--page-title-block.html.twig


                   * block--core.html.twig


                   x block.html.twig


                -->


                <!-- BEGIN OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


                <div id="block-pana-page-title" class="block block-core block-page-title-block">


                    <div class="container-wrap clearfix">


                        <div class="block-content">


                            <!-- THEME DEBUG -->


                            <!-- THEME HOOK: 'page_title' -->


                            <!-- BEGIN OUTPUT from 'core/themes/stable/templates/content/page-title.html.twig' -->


                            <h1>Create new account</h1>


                            <!-- END OUTPUT from 'core/themes/stable/templates/content/page-title.html.twig' -->


                        </div>


                    </div>


                </div>


                <!-- END OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


            </div>


            <!-- END OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


        </div>


    </section>


    <!-- End Page Title -->


    <!-- Start content top -->


    <section id="content-wide-top" class="content-wide">


        <!-- THEME DEBUG -->


        <!-- THEME HOOK: 'region' -->


        <!-- FILE NAME SUGGESTIONS:


           * region--content-wide-top.html.twig


           x region.html.twig


        -->


        <!-- BEGIN OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


        <div class="region region-content-wide-top">


            <!-- THEME DEBUG -->


            <!-- THEME HOOK: 'block' -->


            <!-- FILE NAME SUGGESTIONS:


               * block--pana-local-tasks.html.twig


               * block--local-tasks-block.html.twig


               * block--core.html.twig


               x block.html.twig


            -->


            <!-- BEGIN OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


            <div id="block-pana-local-tasks"
                 class="norm-width block-title-2 block-title-left block block-core block-local-tasks-block">


                <div class="container-wrap clearfix">


                    <div class="block-content">


                        <!-- THEME DEBUG -->


                        <!-- THEME HOOK: 'menu_local_tasks' -->


                        <!-- BEGIN OUTPUT from 'themes/pana/templates/navigation/menu-local-tasks.html.twig' -->


                        <div class="task-bar alert alert-dismissable clearfix">


                            <div class="clearfix">


                                <div class="col-md-12">


                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>


                                    <h2 class="visually-hidden">Primary tabs</h2>


                                    <ul class="tabs">


                                        <!-- THEME DEBUG -->


                                        <!-- THEME HOOK: 'menu_local_task' -->


                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/navigation/menu-local-task.html.twig' -->


                                        <li><a href="user/login.php" data-drupal-link-system-path="user/login">Log in</a></li>


                                        <!-- END OUTPUT from 'themes/pana/templates/navigation/menu-local-task.html.twig' -->


                                        <!-- THEME DEBUG -->


                                        <!-- THEME HOOK: 'menu_local_task' -->


                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/navigation/menu-local-task.html.twig' -->


                                        <li class="is-active"><a href="register"
                                                                 data-drupal-link-system-path="user/register"
                                                                 class="is-active">Create new account<span
                                                        class="visually-hidden">(active tab)</span></a></li>


                                        <!-- END OUTPUT from 'themes/pana/templates/navigation/menu-local-task.html.twig' -->


                                        <!-- THEME DEBUG -->


                                        <!-- THEME HOOK: 'menu_local_task' -->


                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/navigation/menu-local-task.html.twig' -->


                                        <!-- <li><a href="password" data-drupal-link-system-path="user/password">Reset your password</a></li> -->


                                        <!-- END OUTPUT from 'themes/pana/templates/navigation/menu-local-task.html.twig' -->


                                    </ul>


                                </div>


                            </div>


                        </div>


                        <!-- END OUTPUT from 'themes/pana/templates/navigation/menu-local-tasks.html.twig' -->


                    </div>


                </div>


            </div>


            <!-- END OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


        </div>


        <!-- END OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


    </section>


    <!-- End content top -->


    <!-- layout -->


    <section id="page-wrapper" class="page-wrapper">


        <div class="container">


            <div class="row content-layout">


                <!--- Start content -->


                <div class="col-md-12  main-content">


                    <!-- THEME DEBUG -->


                    <!-- THEME HOOK: 'region' -->


                    <!-- FILE NAME SUGGESTIONS:


                       * region--content.html.twig


                       x region.html.twig


                    -->


                    <!-- BEGIN OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


                    <div class="region region-content">


                        <!-- THEME DEBUG -->


                        <!-- THEME HOOK: 'block' -->


                        <!-- FILE NAME SUGGESTIONS:


                           * block--messages.html.twig


                           x block--system-messages-block.html.twig


                           * block--system.html.twig


                           * block.html.twig


                        -->


                        <!-- BEGIN OUTPUT from 'core/themes/stable/templates/block/block--system-messages-block.html.twig' -->


                        <div data-drupal-messages-fallback class="hidden"></div>


                        <!-- END OUTPUT from 'core/themes/stable/templates/block/block--system-messages-block.html.twig' -->


                        <!-- THEME DEBUG -->


                        <!-- THEME HOOK: 'block' -->


                        <!-- FILE NAME SUGGESTIONS:


                           * block--pana-content.html.twig


                           * block--system-main-block.html.twig


                           * block--system.html.twig


                           x block.html.twig


                        -->


                        <!-- BEGIN OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


                        <div id="block-pana-content--2" class="block block-system block-system-main-block">


                            <div class="container-wrap clearfix">


                                <div class="block-content">


                                    <!-- THEME DEBUG -->


                                    <!-- THEME HOOK: 'form' -->


                                    <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/form.html.twig' -->
                                    <?php
session_start();
    include_once "config.php";
    if (isset($_REQUEST["op"])) {
        $mail = trim(addslashes($_REQUEST["mail"]));
        $name = trim(addslashes($_REQUEST["name"]));
        $password = trim(addslashes($_REQUEST["password"]));
        $password_hash = md5($password);
        $strlenname = strlen($name);
        $strlenpass = strlen($password);
        if ($strlenname > 5) {
            if ($strlenpass > 7) {
                $user_info = $db->selectFrom("SELECT * FROM `signup` WHERE email='$mail'");
                $dbemail = $user_info["email"];
                $user_info_two = $db->selectFrom("SELECT * FROM `signup` WHERE username='$name'");
                $dbusername = $user_info_two["username"];
                //Verify User
                if ($mail == $dbemail) {
                    echo "<div class=\"alert\" style=\"background: #ffda94;color: #333;\">You are Registered</div>";
                } else {
                    if ($name == $dbusername) {
                        echo "<div class=\"alert\" style=\"background: #ffda94;color: #333;\">Username already exists.</div>";
                    } else {
                        $fields = "email,username,password";
                        $vals = "'$mail','$name','$password_hash'";
                        $insert = $db->Add_Record("signup", $fields, $vals);
                        if ($insert == true) {
                            // $user_info_four = $db->selectFrom("select * from users where 1");
                            // $emailsend = $user_info_four["email"];
                            $emailsend = "mdalamin6554@gmail.com";
                            $subject = "You got a New User Username: $name";
                            $message = "
                                                            <html>
                                                            <head>
                                                            <title>You got a New User Username: $name</title>
                                                            </head>
                                                            <body>
                                                            <p>You got a New User Username: $name</p>
                                                            <table style='font-weight:500;text-algin:left;'>
                                                            <tr> <th>Userame: </th> <th>Email: </th> </tr>
                                                            <tr> <td>$name</td>   <td>$mail</td>     </tr>
                                                            <tr><a href='http://bio.dsoftwaretechnology.com/admin/add_member.php?type=1'>Add speakers</a></tr>
                                                            <tr><a href='http://bio.dsoftwaretechnology.com/admin/add_sponsor.php'>Add sponsors</a></tr>
                                                            <tr><a href='http://bio.dsoftwaretechnology.com/admin/add_member.php?type=3'>Add cabinet</a></tr>
                                                            </table>
                                                            </body>
                                                            </html>
                                                            ";
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                            mail($emailsend, $subject, $message, $headers);
                            print_r($emailsend, $subject, $message, $headers);
                            echo "<div class=\"alert\" style=\"background: #ffda94;color: #333;\">Success</div>";
                        } else {
                            echo "<div class=\"alert\" style=\"background: #ffda94;color: #333;\">Technical Issue Please Try Again</div>";
                        }
                    }
                }
            } else {
                echo "<div class=\"alert\" style=\"background: #ffda94;color: #333;\">Password need 8 charset</div>";
            }
        } else {
            echo "<div class=\"alert\" style=\"background: #ffda94;color: #333;\">Please Type Valid Username</div>";
        }
    }
    ?>

                                    <form class="user-register-form user-form" data-user-info-from-browser
                                          data-drupal-selector="user-register-form" action="" method="post"
                                          id="user-register-form" accept-charset="UTF-8">


                                        <!-- THEME DEBUG -->


                                        <!-- THEME HOOK: 'container' -->


                                        <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/container.html.twig' -->


                                        <div data-drupal-selector="edit-account" id="edit-account"
                                             class="js-form-wrapper form-wrapper">


                                            <!-- THEME DEBUG -->


                                            <!-- THEME HOOK: 'form_element' -->


                                            <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/form-element.html.twig' -->


                                            <div class="js-form-item form-item js-form-type-email form-item-mail js-form-item-mail">


                                                <!-- THEME DEBUG -->


                                                <!-- THEME HOOK: 'form_element_label' -->


                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/form-element-label.html.twig' -->


                                                <label for="edit-mail" class="js-form-required form-required">Email address</label>


                                                <!-- END OUTPUT from 'core/themes/stable/templates/form/form-element-label.html.twig' -->


                                                <!-- THEME DEBUG -->


                                                <!-- THEME HOOK: 'input__email' -->


                                                <!-- FILE NAME SUGGESTIONS:


                                                   * input--email.html.twig


                                                   x input.html.twig


                                                -->


                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                                <input data-drupal-selector="edit-mail"
                                                       aria-describedby="edit-mail--description" type="email"
                                                       id="edit-mail" name="mail" value="" size="60" maxlength="254"
                                                       class="form-email required" required="required"
                                                       aria-required="true"/>


                                                <!-- END OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                                <div id="edit-mail--description" class="description">


                                                    A valid email address. All emails from the system will be sent to
                                                    this address. The email address is not made public and will only be
                                                    used if you wish to receive a new password or wish to receive
                                                    certain news or notifications by email.


                                                </div>


                                            </div>


                                            <!-- END OUTPUT from 'core/themes/stable/templates/form/form-element.html.twig' -->


                                            <!-- THEME DEBUG -->


                                            <!-- THEME HOOK: 'form_element' -->


                                            <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/form-element.html.twig' -->


                                            <div class="js-form-item form-item js-form-type-textfield form-item-name js-form-item-name">


                                                <!-- THEME DEBUG -->


                                                <!-- THEME HOOK: 'form_element_label' -->


                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/form-element-label.html.twig' -->


                                                <label for="edit-name"
                                                       class="js-form-required form-required">Username</label>


                                                <!-- END OUTPUT from 'core/themes/stable/templates/form/form-element-label.html.twig' -->

                                                <!-- THEME DEBUG -->


                                                <!-- THEME HOOK: 'input__textfield' -->


                                                <!-- FILE NAME SUGGESTIONS:


                                                   * input--textfield.html.twig


                                                   x input.html.twig


                                                -->


                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                                <input class="password form-text required" autocorrect="off"
                                                       autocapitalize="off" spellcheck="false"
                                                       data-drupal-selector="edit-name"
                                                       aria-describedby="edit-name--description" type="text"
                                                       id="edit-name" name="name" value="" size="60" maxlength="60"
                                                       required="required" aria-required="true"/>

                                                <label for="edit-password" class="js-form-required form-required">Password</label>


                                                <!-- END OUTPUT from 'core/themes/stable/templates/form/form-element-label.html.twig' -->

                                                <!-- THEME DEBUG -->


                                                <!-- THEME HOOK: 'input__textfield' -->


                                                <!-- FILE NAME SUGGESTIONS:


                                                   * input--textfield.html.twig


                                                   x input.html.twig


                                                -->


                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                                <input class="password form-text required" autocorrect="off"
                                                       autocapitalize="off" spellcheck="false"
                                                       data-drupal-selector="edit-name"
                                                       aria-describedby="edit-name--description" type="password"
                                                       id="edit-password" style="margin-top: 1rem;" name="password"
                                                       value="" size="60" maxlength="60" required="required"
                                                       aria-required="true"/>

                                                <!-- END OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->
                                                <div id="edit-name--description" class="description">


                                                    Several special characters are allowed, including space, period (.),
                                                    hyphen (-), apostrophe ('), underscore (_), and the @ sign.


                                                </div>


                                            </div>


                                            <!-- END OUTPUT from 'core/themes/stable/templates/form/form-element.html.twig' -->


                                        </div>


                                        <!-- END OUTPUT from 'core/themes/stable/templates/form/container.html.twig' -->


                                        <!-- THEME DEBUG -->


                                        <!-- THEME HOOK: 'input__hidden' -->


                                        <!-- FILE NAME SUGGESTIONS:


                                           * input--hidden.html.twig


                                           x input.html.twig


                                        -->


                                        <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                        <input autocomplete="off"
                                               data-drupal-selector="form-d-db5tearh49ge9moehf78h67uxcmf4jh1mgutfngtk"
                                               type="hidden" name="form_build_id"
                                               value="form-D-Db5TEARH49ge9moehf78h67UXCMF4jh1mgutFNGtk"/>


                                        <!-- END OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                        <!-- THEME DEBUG -->


                                        <!-- THEME HOOK: 'input__hidden' -->


                                        <!-- FILE NAME SUGGESTIONS:


                                           * input--hidden.html.twig


                                           x input.html.twig


                                        -->


                                        <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                        <input data-drupal-selector="edit-user-register-form" type="hidden"
                                               name="form_id" value="user_register_form"/>


                                        <!-- END OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                        <!-- THEME DEBUG -->


                                        <!-- THEME HOOK: 'container' -->


                                        <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/container.html.twig' -->


                                        <div data-drupal-selector="edit-actions"
                                             class="form-actions js-form-wrapper form-wrapper" id="edit-actions">


                                            <!-- THEME DEBUG -->


                                            <!-- THEME HOOK: 'input__submit' -->


                                            <!-- FILE NAME SUGGESTIONS:


                                               * input--submit.html.twig


                                               x input.html.twig


                                            -->


                                            <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                            <input data-drupal-selector="edit-submit" type="submit" id="edit-submit"
                                                   name="op" value="Create new account"
                                                   class="button button--primary js-form-submit form-submit"/>


                                            <!-- END OUTPUT from 'core/themes/stable/templates/form/input.html.twig' -->


                                        </div>


                                        <!-- END OUTPUT from 'core/themes/stable/templates/form/container.html.twig' -->


                                    </form>


                                    <!-- END OUTPUT from 'core/themes/stable/templates/form/form.html.twig' -->


                                </div>


                            </div>


                        </div>


                        <!-- END OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


                    </div>


                    <!-- END OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


                </div>


                <!---End content -->


            </div>


        </div>


        <div class="container-fluid width--adjustment pt-3">


            <div class="row">


                <div class="col-md-6">


                    <!-- THEME DEBUG -->


                    <!-- THEME HOOK: 'region' -->


                    <!-- FILE NAME SUGGESTIONS:


                       * region--custom-left.html.twig


                       x region.html.twig


                    -->


                    <!-- BEGIN OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


                    <div class="region region-custom-left">


                        <!-- THEME DEBUG -->


                        <!-- THEME HOOK: 'block' -->


                        <!-- FILE NAME SUGGESTIONS:


                           * block--views-block--blog-latest-blog-grid-3.html.twig


                           * block--views-block--blog-latest-blog-grid.html.twig


                           * block--views-block.html.twig


                           * block--views.html.twig


                           x block.html.twig


                        -->


                        <!-- BEGIN OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


                        <div class="views-element-container norm-width block-title-1 block-title-left block block-views block-views-blockblog-latest-blog-grid"
                             id="block-views-block-blog-latest-blog-grid-3">


                            <div class="container-wrap clearfix">


                                <div class="block-title-wrap clearfix">


                                    <div class="block-title-content">


                                        <h2 class="block-title">Latest News</h2>


                                    </div>


                                </div>


                                <div class="block-content">


                                    <!-- THEME DEBUG -->


                                    <!-- THEME HOOK: 'container' -->


                                    <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/container.html.twig' -->


                                    <div>


                                        <!-- THEME DEBUG -->


                                        <!-- THEME HOOK: 'views_view' -->


                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/views/views-view.html.twig' -->


                                        <div class="js-view-dom-id-8d750bd52bceb8930cd4daec22b68278d20d28346cb6c9d83f27a14aaec575f3">


                                        <div class="rss-flex-container">

<iframe class="widget_preview_iframe" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen="" scrolling="no" style="visibility: visible; width: 700px; height: 1198px;" src="https://www.feedspot.com/widgets/lookup/507674eeSpm5"></iframe>

</div>

                                            <!-- THEME DEBUG -->


                                            <!-- THEME HOOK: 'views_bootstrap_grid_views' -->


                                            <!-- BEGIN OUTPUT from 'modules/custom/views_bootstrap_grid/templates/views-bootstrap-grid-views.html.twig' -->



                                            <!-- END OUTPUT from 'modules/custom/views_bootstrap_grid/templates/views-bootstrap-grid-views.html.twig' -->


                                            <footer>

                                            <br></br>
                                            <br></br>
                                                <div class="text-center negative-margin-button"><a href="/news"
                                                    class="button">View More News</a></div>


                                            </footer>


                                        </div>


                                        <!-- END OUTPUT from 'themes/pana/templates/views/views-view.html.twig' -->


                                    </div>


                                    <!-- END OUTPUT from 'core/themes/stable/templates/form/container.html.twig' -->


                                </div>


                            </div>


                        </div>


                        <!-- END OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


                    </div>


                    <!-- END OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


                </div>


                <div class="col-md-6">


                    <!-- THEME DEBUG -->


                    <!-- THEME HOOK: 'region' -->


                    <!-- FILE NAME SUGGESTIONS:


                       * region--custom-right.html.twig


                       x region.html.twig


                    -->


                    <!-- BEGIN OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


                    <div class="region region-custom-right">


                        <!-- THEME DEBUG -->


                        <!-- THEME HOOK: 'block' -->


                        <!-- FILE NAME SUGGESTIONS:


                           * block--views-block--event-listing-block-1.html.twig


                           * block--views-block--event-listing-block-1.html.twig


                           * block--views-block.html.twig


                           * block--views.html.twig


                           x block.html.twig


                        -->


                        <!-- BEGIN OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


                        <div class="views-element-container norm-width block-title-1 block-title-left block block-views block-views-blockevent-listing-block-1"
                             id="block-views-block-event-listing-block-1">


                            <div class="container-wrap clearfix">


                                <div class="block-title-wrap clearfix">


                                    <div class="block-title-content">


                                        <h2 class="block-title">Events</h2>


                                    </div>


                                </div>


                                <div class="block-content">


                                    <!-- THEME DEBUG -->


                                    <!-- THEME HOOK: 'container' -->


                                    <!-- BEGIN OUTPUT from 'core/themes/stable/templates/form/container.html.twig' -->


                                    <div>


                                        <!-- THEME DEBUG -->


                                        <!-- THEME HOOK: 'views_view' -->


                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/views/views-view.html.twig' -->


                                        <div class="js-view-dom-id-808f061bacc345c2dba16fb70cbac31f9468d19df1ea394d2b03d50c967db66f">


                                            <!-- THEME DEBUG -->


                                            <!-- THEME HOOK: 'views_view_unformatted' -->


                                            <!-- BEGIN OUTPUT from 'themes/pana/templates/views/views-view-unformatted.html.twig' -->


                                            <div>


                                                <!-- THEME DEBUG -->


                                                <!-- THEME HOOK: 'commerce_product' -->


                                                <!-- FILE NAME SUGGESTIONS:


                                                   * commerce-product--14--teaser.html.twig


                                                   * commerce-product--14.html.twig


                                                   x commerce-product--event--teaser.html.twig


                                                   * commerce-product--event.html.twig


                                                   * commerce-product--teaser.html.twig


                                                   * commerce-product.html.twig


                                                -->


                                                <!-- BEGIN OUTPUT from 'themes/pana/templates/commerce/commerce-product--event--teaser.html.twig' -->


                                                <div class="product-teaser event-teaser">


                                                    <div class="event-image">


                                                        <!-- THEME DEBUG -->


                                                        <!-- THEME HOOK: 'field' -->


                                                        <!-- FILE NAME SUGGESTIONS:


                                                           * field--commerce-product--field-image--event.html.twig


                                                           * field--commerce-product--field-image.html.twig


                                                           * field--commerce-product--event.html.twig


                                                           x field--field-image.html.twig


                                                           * field--image.html.twig


                                                           * field.html.twig


                                                        -->


                                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field--field-image.html.twig' -->


                                                        <div class="field field-field-image field-label-hidden field-item">


                                                            <!-- THEME DEBUG -->


                                                            <!-- THEME HOOK: 'image_formatter' -->


                                                            <!-- BEGIN OUTPUT from 'core/themes/stable/templates/field/image-formatter.html.twig' -->


                                                            <a href="postponed-mindful-developing-situation-regarding-coronavirus-covid-19"
                                                               hreflang="en">


                                                                <!-- THEME DEBUG -->


                                                                <!-- THEME HOOK: 'image_style' -->


                                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/field/image-style.html.twig' -->


                                                                <!-- THEME DEBUG -->


                                                                <!-- THEME HOOK: 'image' -->


                                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/field/image.html.twig' -->


                                                                <img src="images/mastersofreal.jpg"
                                                                     width="480" height="480" alt="event"
                                                                     typeof="foaf:Image"/>


                                                                <!-- END OUTPUT from 'core/themes/stable/templates/field/image.html.twig' -->


                                                                <!-- END OUTPUT from 'core/themes/stable/templates/field/image-style.html.twig' -->


                                                            </a>


                                                            <!-- END OUTPUT from 'core/themes/stable/templates/field/image-formatter.html.twig' -->


                                                        </div>


                                                        <!-- END OUTPUT from 'themes/pana/templates/field/field--field-image.html.twig' -->


                                                    </div>


                                                    <div class="event-content-wrap">


                                                        <div class="event-content-container">


                                                            <div class="event-content">


                                                                <div class="event-title">


                                                                    <a href="postponed-mindful-developing-situation-regarding-coronavirus-covid-19">


                                                                        <!-- THEME DEBUG -->


                                                                        <!-- THEME HOOK: 'field' -->


                                                                        <!-- FILE NAME SUGGESTIONS:


                                                                           * field--commerce-product--title--event.html.twig


                                                                           * field--commerce-product--title.html.twig


                                                                           * field--commerce-product--event.html.twig


                                                                           * field--title.html.twig


                                                                           * field--string.html.twig


                                                                           x field.html.twig


                                                                        -->


                                                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                        <div class="field field-title field-label-hidden field-item">
                                                                            Postponed-Mindful Of The Developing
                                                                            Situation Regarding The Coronavirus
                                                                            (COVID-19)...
                                                                        </div>


                                                                        <!-- END OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                    </a>


                                                                    <div class="event-price"></div>


                                                                </div>


                                                                <div class="event-meta">


                                                                    <div class="event-date-wrap">


                                                                        <div class="event-date">


                                                                            <span class="event-date-day">14th</span>


                                                                            <span class="event-date-month">May</span>


                                                                            <span class="event-date-year">2020</span>


                                                                        </div>


                                                                    </div>


                                                                    <div class="event-time">


                                                                        <span class="ion-ios-clock-outline"></span> 8:30
                                                                        AM


                                                                    </div>


                                                                    <div class="event-venue-wrap">


                                                                        <span class="ion-ios-location"></span>


                                                                        <div class="event-venue">Chicago,
                                                                            IL<span>,</span></div>


                                                                        <div class="event-location">


                                                                            <!-- THEME DEBUG -->


                                                                            <!-- THEME HOOK: 'field' -->


                                                                            <!-- FILE NAME SUGGESTIONS:


                                                                               * field--commerce-product--field-event-location--event.html.twig


                                                                               * field--commerce-product--field-event-location.html.twig


                                                                               * field--commerce-product--event.html.twig


                                                                               * field--field-event-location.html.twig


                                                                               * field--entity-reference.html.twig


                                                                               x field.html.twig


                                                                            -->


                                                                            <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                            <div class="field field-field-event-location field-label-hidden field-item">
                                                                                <a href="/events?f%5B0%5D=event-location%3A52&amp;taxonomy_term=26"
                                                                                   rel="nofollow">Seyfarth Shaw</a>
                                                                            </div>


                                                                            <!-- END OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                        </div>


                                                                    </div>


                                                                </div>


                                                            </div>


                                                        </div>


                                                    </div>


                                                    <div class="event-button">


                                                        <a class="button"
                                                           href="postponed-mindful-developing-situation-regarding-coronavirus-covid-19">Register
                                                            Now</a>


                                                    </div>


                                                </div>


                                                <!-- END OUTPUT from 'themes/pana/templates/commerce/commerce-product--event--teaser.html.twig' -->


                                            </div>


                                            <div>


                                                <!-- THEME DEBUG -->


                                                <!-- THEME HOOK: 'commerce_product' -->


                                                <!-- FILE NAME SUGGESTIONS:


                                                   * commerce-product--17--teaser.html.twig


                                                   * commerce-product--17.html.twig


                                                   x commerce-product--event--teaser.html.twig


                                                   * commerce-product--event.html.twig


                                                   * commerce-product--teaser.html.twig


                                                   * commerce-product.html.twig


                                                -->


                                                <!-- BEGIN OUTPUT from 'themes/pana/templates/commerce/commerce-product--event--teaser.html.twig' -->


                                                <div class="product-teaser event-teaser">


                                                    <div class="event-image">


                                                        <!-- THEME DEBUG -->


                                                        <!-- THEME HOOK: 'field' -->


                                                        <!-- FILE NAME SUGGESTIONS:


                                                           * field--commerce-product--field-image--event.html.twig


                                                           * field--commerce-product--field-image.html.twig


                                                           * field--commerce-product--event.html.twig


                                                           x field--field-image.html.twig


                                                           * field--image.html.twig


                                                           * field.html.twig


                                                        -->


                                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field--field-image.html.twig' -->


                                                        <div class="field field-field-image field-label-hidden field-item">


                                                            <!-- THEME DEBUG -->


                                                            <!-- THEME HOOK: 'image_formatter' -->


                                                            <!-- BEGIN OUTPUT from 'core/themes/stable/templates/field/image-formatter.html.twig' -->


                                                            <a href="masters-conference-denver" hreflang="en">


                                                                <!-- THEME DEBUG -->


                                                                <!-- THEME HOOK: 'image_style' -->


                                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/field/image-style.html.twig' -->


                                                                <!-- THEME DEBUG -->


                                                                <!-- THEME HOOK: 'image' -->


                                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/field/image.html.twig' -->


                                                                <img src="images/mastersofreal.jpg"
                                                                     width="480" height="480" alt="event"
                                                                     typeof="foaf:Image"/>


                                                                <!-- END OUTPUT from 'core/themes/stable/templates/field/image.html.twig' -->


                                                                <!-- END OUTPUT from 'core/themes/stable/templates/field/image-style.html.twig' -->


                                                            </a>


                                                            <!-- END OUTPUT from 'core/themes/stable/templates/field/image-formatter.html.twig' -->


                                                        </div>


                                                        <!-- END OUTPUT from 'themes/pana/templates/field/field--field-image.html.twig' -->


                                                    </div>


                                                    <div class="event-content-wrap">


                                                        <div class="event-content-container">


                                                            <div class="event-content">


                                                                <div class="event-title">


                                                                    <a href="masters-conference-denver">


                                                                        <!-- THEME DEBUG -->


                                                                        <!-- THEME HOOK: 'field' -->


                                                                        <!-- FILE NAME SUGGESTIONS:


                                                                           * field--commerce-product--title--event.html.twig


                                                                           * field--commerce-product--title.html.twig


                                                                           * field--commerce-product--event.html.twig


                                                                           * field--title.html.twig


                                                                           * field--string.html.twig


                                                                           x field.html.twig


                                                                        -->


                                                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                        <div class="field field-title field-label-hidden field-item">
                                                                            Master&#039;s Conference - Denver ...
                                                                        </div>


                                                                        <!-- END OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                    </a>


                                                                    <div class="event-price"></div>


                                                                </div>


                                                                <div class="event-meta">


                                                                    <div class="event-date-wrap">


                                                                        <div class="event-date">


                                                                            <span class="event-date-day">10th</span>


                                                                            <span class="event-date-month">Jun</span>


                                                                            <span class="event-date-year">2020</span>


                                                                        </div>


                                                                    </div>


                                                                    <div class="event-time">


                                                                        <span class="ion-ios-clock-outline"></span> 8:15
                                                                        AM


                                                                    </div>


                                                                    <div class="event-venue-wrap">


                                                                        <span class="ion-ios-location"></span>


                                                                        <div class="event-venue">Denver,
                                                                            CO<span>,</span></div>


                                                                        <div class="event-location">


                                                                            <!-- THEME DEBUG -->


                                                                            <!-- THEME HOOK: 'field' -->


                                                                            <!-- FILE NAME SUGGESTIONS:


                                                                               * field--commerce-product--field-event-location--event.html.twig


                                                                               * field--commerce-product--field-event-location.html.twig


                                                                               * field--commerce-product--event.html.twig


                                                                               * field--field-event-location.html.twig


                                                                               * field--entity-reference.html.twig


                                                                               x field.html.twig


                                                                            -->


                                                                            <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                            <div class="field field-field-event-location field-label-hidden field-item">
                                                                                <a href="/events?f%5B0%5D=event-location%3A53&amp;taxonomy_term=26"
                                                                                   rel="nofollow">Polsinelli</a></div>


                                                                            <!-- END OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                        </div>


                                                                    </div>


                                                                </div>


                                                            </div>


                                                        </div>


                                                    </div>


                                                    <div class="event-button">


                                                        <a class="button" href="masters-conference-denver">Register
                                                            Now</a>


                                                    </div>


                                                </div>


                                                <!-- END OUTPUT from 'themes/pana/templates/commerce/commerce-product--event--teaser.html.twig' -->


                                            </div>


                                            <div>


                                                <!-- THEME DEBUG -->


                                                <!-- THEME HOOK: 'commerce_product' -->


                                                <!-- FILE NAME SUGGESTIONS:


                                                   * commerce-product--5--teaser.html.twig


                                                   * commerce-product--5.html.twig


                                                   x commerce-product--event--teaser.html.twig


                                                   * commerce-product--event.html.twig


                                                   * commerce-product--teaser.html.twig


                                                   * commerce-product.html.twig


                                                -->


                                                <!-- BEGIN OUTPUT from 'themes/pana/templates/commerce/commerce-product--event--teaser.html.twig' -->


                                                <div class="product-teaser event-teaser">


                                                    <div class="event-image">


                                                        <!-- THEME DEBUG -->


                                                        <!-- THEME HOOK: 'field' -->


                                                        <!-- FILE NAME SUGGESTIONS:


                                                           * field--commerce-product--field-image--event.html.twig


                                                           * field--commerce-product--field-image.html.twig


                                                           * field--commerce-product--event.html.twig


                                                           x field--field-image.html.twig


                                                           * field--image.html.twig


                                                           * field.html.twig


                                                        -->


                                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field--field-image.html.twig' -->


                                                        <div class="field field-field-image field-label-hidden field-item">


                                                            <!-- THEME DEBUG -->


                                                            <!-- THEME HOOK: 'image_formatter' -->


                                                            <!-- BEGIN OUTPUT from 'core/themes/stable/templates/field/image-formatter.html.twig' -->


                                                            <a href="masters-conference-new-york-ny" hreflang="en">


                                                                <!-- THEME DEBUG -->


                                                                <!-- THEME HOOK: 'image_style' -->


                                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/field/image-style.html.twig' -->


                                                                <!-- THEME DEBUG -->


                                                                <!-- THEME HOOK: 'image' -->


                                                                <!-- BEGIN OUTPUT from 'core/themes/stable/templates/field/image.html.twig' -->


                                                                <img src="images/mastersofreal.jpg"
                                                                     width="480" height="480" alt="event"
                                                                     typeof="foaf:Image"/>


                                                                <!-- END OUTPUT from 'core/themes/stable/templates/field/image.html.twig' -->


                                                                <!-- END OUTPUT from 'core/themes/stable/templates/field/image-style.html.twig' -->


                                                            </a>


                                                            <!-- END OUTPUT from 'core/themes/stable/templates/field/image-formatter.html.twig' -->


                                                        </div>


                                                        <!-- END OUTPUT from 'themes/pana/templates/field/field--field-image.html.twig' -->


                                                    </div>


                                                    <div class="event-content-wrap">


                                                        <div class="event-content-container">


                                                            <div class="event-content">


                                                                <div class="event-title">


                                                                    <a href="masters-conference-new-york-ny">


                                                                        <!-- THEME DEBUG -->


                                                                        <!-- THEME HOOK: 'field' -->


                                                                        <!-- FILE NAME SUGGESTIONS:


                                                                           * field--commerce-product--title--event.html.twig


                                                                           * field--commerce-product--title.html.twig


                                                                           * field--commerce-product--event.html.twig


                                                                           * field--title.html.twig


                                                                           * field--string.html.twig


                                                                           x field.html.twig


                                                                        -->


                                                                        <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                        <div class="field field-title field-label-hidden field-item">
                                                                            Master&#039;s Conference - New York, NY
                                                                        </div>


                                                                        <!-- END OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                    </a>


                                                                    <div class="event-price"></div>


                                                                </div>


                                                                <div class="event-meta">


                                                                    <div class="event-date-wrap">


                                                                        <div class="event-date">


                                                                            <span class="event-date-day">14th</span>


                                                                            <span class="event-date-month">Jul</span>


                                                                            <span class="event-date-year">2020</span>


                                                                        </div>


                                                                    </div>


                                                                    <div class="event-time">


                                                                        <span class="ion-ios-clock-outline"></span> 8:30
                                                                        AM


                                                                    </div>


                                                                    <div class="event-venue-wrap">


                                                                        <span class="ion-ios-location"></span>


                                                                        <div class="event-venue">New York,
                                                                            NY<span>,</span></div>


                                                                        <div class="event-location">


                                                                            <!-- THEME DEBUG -->


                                                                            <!-- THEME HOOK: 'field' -->


                                                                            <!-- FILE NAME SUGGESTIONS:


                                                                               * field--commerce-product--field-event-location--event.html.twig


                                                                               * field--commerce-product--field-event-location.html.twig


                                                                               * field--commerce-product--event.html.twig


                                                                               * field--field-event-location.html.twig


                                                                               * field--entity-reference.html.twig


                                                                               x field.html.twig


                                                                            -->


                                                                            <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                            <div class="field field-field-event-location field-label-hidden field-item">
                                                                                <a href="/events?f%5B0%5D=event-location%3A54&amp;taxonomy_term=26"
                                                                                   rel="nofollow">Crowell &amp; Moring
                                                                                    LLP</a></div>


                                                                            <!-- END OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                                                        </div>


                                                                    </div>


                                                                </div>


                                                            </div>


                                                        </div>


                                                    </div>


                                                    <div class="event-button">


                                                        <a class="button" href="masters-conference-new-york-ny">Register
                                                            Now</a>


                                                    </div>


                                                </div>


                                                <!-- END OUTPUT from 'themes/pana/templates/commerce/commerce-product--event--teaser.html.twig' -->


                                            </div>


                                            <!-- END OUTPUT from 'themes/pana/templates/views/views-view-unformatted.html.twig' -->


                                            <!-- THEME DEBUG -->


                                            <!-- THEME HOOK: 'pager' -->


                                            <!-- BEGIN OUTPUT from 'themes/pana/templates/navigation/pager.html.twig' -->


                                            <nav class="pager" aria-labelledby="pagination-heading">


                                                <h4 id="pagination-heading" class="visually-hidden">Pagination</h4>


                                                <ul class="pager__items js-pager__items">


                                                    <li class="pager__item is-active">


                                                        <a href="?page=0" title="Current page">


            <span class="visually-hidden">


              Current page


            </span>1</a>


                                                    </li>


                                                    <li class="pager__item">


                                                        <a href="?page=1" title="Go to page 2">


            <span class="visually-hidden">


              Page


            </span>2</a>


                                                    </li>


                                                    <li class="pager__item pager__item--next">


                                                        <a href="?page=1" title="Go to next page" rel="next">


                                                            <span class="visually-hidden">Next page</span>


                                                            <span aria-hidden="true">Next ›</span>


                                                        </a>


                                                    </li>


                                                    <li class="pager__item pager__item--last">


                                                        <a href="?page=1" title="Go to last page">


                                                            <span class="visually-hidden">Last page</span>


                                                            <span aria-hidden="true">Last »</span>


                                                        </a>


                                                    </li>


                                                </ul>


                                            </nav>


                                            <!-- END OUTPUT from 'themes/pana/templates/navigation/pager.html.twig' -->


                                        </div>


                                        <!-- END OUTPUT from 'themes/pana/templates/views/views-view.html.twig' -->


                                    </div>


                                    <!-- END OUTPUT from 'core/themes/stable/templates/form/container.html.twig' -->


                                </div>


                            </div>


                        </div>


                        <!-- END OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


                        <!-- THEME DEBUG -->


                        <!-- THEME HOOK: 'block' -->


                        <!-- FILE NAME SUGGESTIONS:


                           * block--speakerrequired.html.twig


                           * block--block-content--740ca462-4a30-440c-9e9f-ffe69309f20f.html.twig


                           * block--block-content.html.twig


                           * block--basic.html.twig


                           * block--block-content.html.twig


                           x block.html.twig


                        -->


                        <!-- BEGIN OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


                        <div id="block-speakerrequired"
                             class="norm-width block-title-1 block-title-left block block-block-content block-block-content740ca462-4a30-440c-9e9f-ffe69309f20f">


                            <div class="container-wrap clearfix">


                                <div class="block-content">


                                    <!-- THEME DEBUG -->


                                    <!-- THEME HOOK: 'field' -->


                                    <!-- FILE NAME SUGGESTIONS:


                                       * field--block-content--body--basic.html.twig


                                       * field--block-content--body.html.twig


                                       * field--block-content--basic.html.twig


                                       * field--body.html.twig


                                       * field--text-with-summary.html.twig


                                       x field.html.twig


                                    -->


                                    <!-- BEGIN OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                    <div class="field field-body field-label-hidden field-item"><p><img
                                                    src="images/mastersofreal.jpg"
                                                    style="display:block; margin:auto;"/></p>


                                    </div>


                                    <!-- END OUTPUT from 'themes/pana/templates/field/field.html.twig' -->


                                </div>


                            </div>


                        </div>


                        <!-- END OUTPUT from 'themes/pana/templates/block/block.html.twig' -->


                    </div>


                    <!-- END OUTPUT from 'themes/pana/templates/region/region.html.twig' -->


                </div>


                <div>


                </div>


    </section>


    <!-- End layout -->


    <?php include_once "pages/footer.php";

}
?>
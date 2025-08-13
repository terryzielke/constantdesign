<?php
/**
 * Template Name: Contact Template
 */

 $form_response = '';
 // Form submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = sanitize_text_field($_POST['fullname']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $company = sanitize_text_field($_POST['company']);
    $services = isset($_POST['services']) ? array_map('sanitize_text_field', $_POST['services']) : [];
    $budget = sanitize_text_field($_POST['budget']);
    $timeline = sanitize_text_field($_POST['timeline']);
    $referral = isset($_POST['referrals']) ? sanitize_text_field($_POST['referrals']) : '';
    $referral_name = sanitize_text_field($_POST['referral_name']);
    $referral_email = sanitize_text_field($_POST['referral_email']);
    $description = wordwrap($_POST['description']);

    // send HTML email
    $to = 'info@constantdesign.ca';
    $subject = 'New Contact Form Submission';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $message = '<!DOCTYPE html>
                    <html>
                        <head>
                            <meta charset="UTF-8">
                            <title>Constant Design</title>
                        </head>
                        <body>
                            <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
                                <tr>
                                    <td>
                                        <table width="600" cellpadding="0" cellspacing="0" style="border-radius:8px; overflow:hidden; font-family:Arial, sans-serif; margin-left: auto; margin-right: auto;box-shadow: 0 10px 20px #ccc;">
                                            <!-- Header -->
                                            <tr>
                                                <td style="padding: 0;">
                                                    <img src="https://constantdesign.ca/wp-content/themes/constantdesign/assets/img/email/email-banner-01.png" alt="Constant Design" style="display:block;max-width:100%;height:auto;">
                                                </td>
                                            </tr>

                                            <!-- Main Message -->
                                            <tr>
                                                <td style="background-color:#101015; padding: 30px;">
                                                    <h2 style="color:#EDEDF4; margin-top:0;">Message sent by '.$fullname.'!</h2>
                                                    <h3 style="color:#EDEDF4; margin-top:0;">Details</h3>
                                                    <p style="color:#EDEDF4; line-height:1.5;">
                                                    <strong>Name: </strong> '.$fullname.'<br>
                                                    <strong>Email: </strong> '.$email.'<br>
                                                    <strong>Phone: </strong> '.$phone.'<br>
                                                    <strong>Company: </strong> '.$company.'<br>
                                                    <strong>Services Needed: </strong> '.implode(', ', $services).'<br>
                                                    <strong>Budget: </strong> '.$budget.'<br>
                                                    <strong>Timeline: </strong> '.$timeline.'<br>
                                                    <br>
                                                    <strong>Referral Type: </strong> '.$referral.'<br>
                                                    <strong>Referral Name: </strong> '.$referral_name.'<br>
                                                    <strong>Referral Email: </strong> '.$referral_email.'<br>
                                                    </p>
                                                    <h3 style="color:#EDEDF4; margin-top:20px;">Project Description</h3>
                                                    <p style="color:#EDEDF4; line-height:1.5;"><strong>Description: </strong></p>
                                                    <div style="color:#EDEDF4;">
                                                    '.$description.'
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Call to Action Buttons -->
                                            <tr>
                                                <td style="background-color:#101015; padding: 0 30px 30px; text-align:center;">
                                                    <a href="mailto:'.$email.'" style="display:inline-block; padding:12px 24px; background-color:#9946FF; color:#ffffff; text-decoration:none; border-radius:5px; margin-right:10px;">Reply to '.$fullname.'</a>
                                                </td>
                                            </tr>

                                            <!-- Footer -->
                                            <tr>
                                                <td style="background-color:#EDEDF4; padding: 20px; text-align:center; font-size:12px; color:#8c8c92;">
                                                © Constant Design. All rights reserved. <br>
                                                This is a notification email, you have not been added to any mailing lists.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </body>
                    </html>';
    
    $sent = wp_mail($to, $subject, $message, $headers);

    if ($sent) {
        $form_response = '<div class="success-message"><h3>Thank you for your message! We will get back to you soon.</h3></div>';
    } else {
        $form_response = '<div class="error-message"><h3>There was an error sending your message. Please try again later.</h3></div>';
    }
}
?>

<section id="contact-section" class="const-human-form">
    <div class="container">
        <div class="content">
            <?php
            if ($form_response){
                echo $form_response;
            } else {
                echo '<h3>Let\'s Work Together</h3>
                		<p>Get a quote, or ask a question. We\'re ready to help!';
            }
            ?>
            <form id="contact-form" method="post" action="#contact-section">

                <fieldset>
                    <h5>Your Details</h5>
                    <input type="text" id="fullname" name="fullname" placeholder="Full Name*" required>
                    <table>
                        <tr>
                            <td>
                                <input type="email" id="email" name="email" placeholder="Email*" required>
                            </td>
                            <td>
                                <input type="tel" id="phone" name="phone" placeholder="Phone">
                            </td>
                        </tr>
                    </table>
                    <input type="text" id="company" name="company" placeholder="Company Name">
                </fieldset>

                <div class="opitons">
                    <a id="i-need-a-quote" class="button">I need a quote</a>
                </div>

                <fieldset id="quote-details">
                    <h5>Services Needed</h5>
                    <ul>
                        <?php
                        $custom_services = get_posts([
                            'post_type' => 'service',
                            'posts_per_page' => -1,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        ]);
                        if ($custom_services) {
                            foreach ($custom_services as $service) {
                                setup_postdata($service);
                                $service_name = get_the_title($service->ID);
                                echo '<li><label><input type="checkbox" name="services[]" value="' . esc_attr($service_name) . '"><span class="checkbox"></span> <span class="label">' . esc_html($service_name) . '<a class="question" data-question-id="'.$service->ID.'"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20">
  <path d="M10,2c4.41121,0,8,3.58879,8,8s-3.58879,8-8,8S2,14.41121,2,10,5.58879,2,10,2M10,1C5.02943,1,1,5.02945,1,10s4.02943,9,9,9,9-4.02943,9-9S14.97056,1,10,1h0Z"/>
  <path d="M9.4017,12.52594l-.0316-.41209c-.0948-.85514.19025-1.79024.98218-2.74018.71262-.83966,1.10858-1.45748,1.10858-2.17009,0-.80806-.50689-1.34655-1.50455-1.36268-.57009,0-1.20403.19025-1.6.49141l-.37985-.99831c.52237-.37985,1.42523-.63329,2.26489-.63329,1.82184,0,2.64538,1.12471,2.64538,2.32809,0,1.07763-.60169,1.85344-1.36203,2.75631-.69714.82418-.95058,1.52068-.90286,2.32874l.01548.41209h-1.23563ZM9.05346,14.74311c0-.58557.39597-.99766.95058-.99766.55397,0,.93446.41209.93446.99766,0,.55461-.36437.98218-.95058.98218-.55461,0-.93446-.42757-.93446-.98218Z"/>
</svg></a></span></label></li>';
                            }
                            wp_reset_postdata();
                        }
                        ?>
                    </ul>
                    <h5>Select Budget Range <a class="header-question question" data-question-id="budget"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20">
  <path d="M10,2c4.41121,0,8,3.58879,8,8s-3.58879,8-8,8S2,14.41121,2,10,5.58879,2,10,2M10,1C5.02943,1,1,5.02945,1,10s4.02943,9,9,9,9-4.02943,9-9S14.97056,1,10,1h0Z"/>
  <path d="M9.4017,12.52594l-.0316-.41209c-.0948-.85514.19025-1.79024.98218-2.74018.71262-.83966,1.10858-1.45748,1.10858-2.17009,0-.80806-.50689-1.34655-1.50455-1.36268-.57009,0-1.20403.19025-1.6.49141l-.37985-.99831c.52237-.37985,1.42523-.63329,2.26489-.63329,1.82184,0,2.64538,1.12471,2.64538,2.32809,0,1.07763-.60169,1.85344-1.36203,2.75631-.69714.82418-.95058,1.52068-.90286,2.32874l.01548.41209h-1.23563ZM9.05346,14.74311c0-.58557.39597-.99766.95058-.99766.55397,0,.93446.41209.93446.99766,0,.55461-.36437.98218-.95058.98218-.55461,0-.93446-.42757-.93446-.98218Z"/>
</svg></a></h5>
                    <select name="budget" id="budget">
                        <option value="under-5000">Under $5,000</option>
                        <option value="5000-10000">$5,000 - $10,000</option>
                        <option value="5000-10000">$10,000 - $50,000</option>
                        <option value="over-10000">Over $50,000</option>
                        <option value="not sure">I'm not sure</option>
                    </select>
                    <h5>Timeline <a class="header-question question" data-question-id="timeline"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20">
  <path d="M10,2c4.41121,0,8,3.58879,8,8s-3.58879,8-8,8S2,14.41121,2,10,5.58879,2,10,2M10,1C5.02943,1,1,5.02945,1,10s4.02943,9,9,9,9-4.02943,9-9S14.97056,1,10,1h0Z"/>
  <path d="M9.4017,12.52594l-.0316-.41209c-.0948-.85514.19025-1.79024.98218-2.74018.71262-.83966,1.10858-1.45748,1.10858-2.17009,0-.80806-.50689-1.34655-1.50455-1.36268-.57009,0-1.20403.19025-1.6.49141l-.37985-.99831c.52237-.37985,1.42523-.63329,2.26489-.63329,1.82184,0,2.64538,1.12471,2.64538,2.32809,0,1.07763-.60169,1.85344-1.36203,2.75631-.69714.82418-.95058,1.52068-.90286,2.32874l.01548.41209h-1.23563ZM9.05346,14.74311c0-.58557.39597-.99766.95058-.99766.55397,0,.93446.41209.93446.99766,0,.55461-.36437.98218-.95058.98218-.55461,0-.93446-.42757-.93446-.98218Z"/>
</svg></a></h5>
                    <input type="text" id="timeline" name="timeline" placeholder="Project Timeline (e.g., Aug 5th)">
                    
                    
                    <h5>What brought you to Constant design?</h5>
                    <ul id="referral-list">
	                    <li><label><input type="radio" name="referrals" value="Goggle"><span class="radio"></span> <span class="label">Google</span></label></li>
	                    <li><label><input type="radio" name="referrals" value="Linked In"><span class="radio"></span> <span class="label">Linked In</span></label></li>
	                    <!--<li><label><input type="radio" name="referrals" value="Social Media"><span class="radio"></span> <span class="label">Social Media</span></label></li>-->
	                    <li><label><input type="radio" name="referrals" value="Referral"><span class="radio"></span> <span class="label">Referral</span></label></li>
                    </ul>
                    <div id="referral-only">
	                    <h5 class="referral-label">Referrer Details <a class="header-question question" data-question-id="referral"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20">
  <path d="M10,2c4.41121,0,8,3.58879,8,8s-3.58879,8-8,8S2,14.41121,2,10,5.58879,2,10,2M10,1C5.02943,1,1,5.02945,1,10s4.02943,9,9,9,9-4.02943,9-9S14.97056,1,10,1h0Z"/>
  <path d="M9.4017,12.52594l-.0316-.41209c-.0948-.85514.19025-1.79024.98218-2.74018.71262-.83966,1.10858-1.45748,1.10858-2.17009,0-.80806-.50689-1.34655-1.50455-1.36268-.57009,0-1.20403.19025-1.6.49141l-.37985-.99831c.52237-.37985,1.42523-.63329,2.26489-.63329,1.82184,0,2.64538,1.12471,2.64538,2.32809,0,1.07763-.60169,1.85344-1.36203,2.75631-.69714.82418-.95058,1.52068-.90286,2.32874l.01548.41209h-1.23563ZM9.05346,14.74311c0-.58557.39597-.99766.95058-.99766.55397,0,.93446.41209.93446.99766,0,.55461-.36437.98218-.95058.98218-.55461,0-.93446-.42757-.93446-.98218Z"/>
</svg></a></h5>
	                    <table>
	                        <tr>
	                            <td>
	                                <input type="text" id="referral_name" name="referral_name" placeholder="Referrer Name">
	                            </td>
	                            <td>
	                                <input type="email" id="referral_email" name="referral_email" placeholder="Referrer Email">
	                            </td>
	                        </tr>
	                    </table>
                    </div>
                </fieldset>
                
                <fieldset>
                    <h5 class="description-label">Tell us about your project! <a class="header-question question" data-question-id="description"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20">
  <path d="M10,2c4.41121,0,8,3.58879,8,8s-3.58879,8-8,8S2,14.41121,2,10,5.58879,2,10,2M10,1C5.02943,1,1,5.02945,1,10s4.02943,9,9,9,9-4.02943,9-9S14.97056,1,10,1h0Z"/>
  <path d="M9.4017,12.52594l-.0316-.41209c-.0948-.85514.19025-1.79024.98218-2.74018.71262-.83966,1.10858-1.45748,1.10858-2.17009,0-.80806-.50689-1.34655-1.50455-1.36268-.57009,0-1.20403.19025-1.6.49141l-.37985-.99831c.52237-.37985,1.42523-.63329,2.26489-.63329,1.82184,0,2.64538,1.12471,2.64538,2.32809,0,1.07763-.60169,1.85344-1.36203,2.75631-.69714.82418-.95058,1.52068-.90286,2.32874l.01548.41209h-1.23563ZM9.05346,14.74311c0-.58557.39597-.99766.95058-.99766.55397,0,.93446.41209.93446.99766,0,.55461-.36437.98218-.95058.98218-.55461,0-.93446-.42757-.93446-.98218Z"/>
</svg></a></h5>
                    <?php
                        wp_editor('', 'description', array(
                            'textarea_name' => 'description',
                            'textarea_rows' => 10,
                            'media_buttons' => false,
                            'teeny' => true,
                            'quicktags' => false
                        ));
                    ?>
                    <div class="submit">
                        <button type="submit" id="send-message" class="button">Send Message</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</section>

<section id="information-wrapper">
    <?php
    $custom_services = get_posts([
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ]);
    if ($custom_services) {
        foreach ($custom_services as $service) {
            setup_postdata($service);
            $service_name = get_the_title($service->ID);
            $service_include = get_post_meta( $service->ID, 'service_include', true );
            ?>
            <div class="info" data-info-id="<?=$service->ID?>">
                <b class="close"></b>
                <h3><?php echo esc_html($service_name); ?></h3>
                <p><strong>Services Include:</strong></p>
                <ul class="services-included">
                    <?php foreach ($service_include as $index => $include) : ?>
                        <li><?php echo esc_attr($include['desc']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        }
        wp_reset_postdata();
    }
    ?>
    <div class="info" data-info-id="budget">
        <b class="close"></b>
        <h3>Why a budget is important</h3>
        <p style="color: #EDEDF4;">Providing a budget range helps us recommend the best solutions for your needs without over- or under-designing. It ensures we focus on the right strategies, tools, and timelines—maximizing value while respecting your investment. Transparency around budget allows us to prioritize effectively and deliver results that align with your goals.</p>
    </div>
    <div class="info" data-info-id="timeline">
        <b class="close"></b>
        <h3>Why provide a timeline</h3>
        <p style="color: #EDEDF4;">Sharing your project timeline helps me plan and prioritize your work alongside other clients, so I can give your project the focus it deserves. It also ensures I can deliver on a schedule that supports your business goals, and it helps me provide an accurate quote—especially if your deadlines may overlap with other projects.</p>
    </div>
    <div class="info" data-info-id="referral">
        <b class="close"></b>
        <h3>Referrer Details</h3>
        <p style="color: #EDEDF4;">You must provide the name and email address of the person who referred you in order to qualify for the <a href="/referrals" target="_blank">Referral Program</a> discount and save up to 15% on your first project with Constant Design.</p>
    </div>
    <div class="info" data-info-id="description">
        <b class="close"></b>
        <h3>What to include in your project description</h3>
        <ul>
            <li>Project goals and objectives</li>
            <li>Target audience and user needs</li>
            <li>Key features or functionalities required</li>
            <li>Design preferences or inspirations</li>
            <li>Challenges or constraints you foresee</li>
            <li>Any specific technologies or platforms you prefer</li>
            <li>Examples of similar projects you admire</li>
            <li>Any additional information that will help us understand your vision</li>
            <li>Other stakeholders involved in the project</li>
        </ul>
    </div>
</section>
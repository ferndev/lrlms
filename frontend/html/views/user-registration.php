<?php
/**
 * User registration form
 * Fernando Martinez
 */
?>
Registration for course<br>
<?php
global $wp_query;
$courseid = $wp_query->get('page');
$coursedata = DbUtil::loadCourse($courseid);
if ($coursedata == null) {
    echo('Course not found<br>');
} else {
    ?>
    You have chosen to register for the following course:<br/>
    <form action="/wordpress496/lrlms_form/course-reg-proceed/" method="post">
        <table width="100%" border="1" cellpadding="1">
            <tr>
                <th scope="row">Course</th>
                <td><?php echo($coursedata['title']); ?></td>
            </tr>
            <tr>
                <th scope="row">Description</th>
                <td><?php echo($coursedata['descr']); ?></td>
            </tr>
            <tr>
                <th scope="row">Duration (weeks)</th>
                <td><?php echo($coursedata['duration']); ?></td>
            </tr>
            <tr>
                <th scope="row">Email support</th>
                <td><?php echo($coursedata['emailsupport']); ?></td>
            </tr>
            <tr>
                <th scope="row">Price</th>
                <td><?php echo($coursedata['price']); ?></td>
            </tr>
        </table>

        <input type="hidden" name="event" value="coursereg">
        <input type="hidden" name="paymproc" value="1">
        <input type="hidden" name="courseid" value="<?php echo($courseid); ?>">
        <?php if ($coursedata['price'] > 0) { ?>
            <input type="submit" value="Pay by Credit Card" name="cardpay" class="tbutton"/>
            <input type="submit" value="Pay by Bank Transfer (South Africa only)" name="bankpay" class="tbutton"/>
        <?php } else { ?>
            <input type="submit" value="Register for this Free course" name="freeofcharge" class="tbutton"/>
        <?php } ?>
    </form>
    <?php
}

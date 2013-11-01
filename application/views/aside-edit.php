<aside class="four columns">
    <h6>Your Information</h6>
    <ul>
        <li>Name: <?php echo $userInfo->fname . ' ' . $userInfo->lname; ?></li>
        <li>Email: <?php echo $userInfo->email; ?></li>
        <li>Address:  <br /><?php echo $userInfo->address . '<br />' . $userInfo->city . ', ' . $userInfo->state . ', ' . $userInfo->zipcode; ?></li>
        <li>Tel:  <?php echo $userInfo->phone; ?></li>
    </ul>
</aside>
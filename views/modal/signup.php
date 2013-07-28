<?php require 'header.php' ?>
<div id="header">
            <h1>Join <span id="pub-count">500+</span> Publishers Who Upgraded</h1>
        </div>
        <div id="clients-section">
            <table id="clients">
                <tr>
                    <td><a href="http://baristanet.com/"><img src="http://broadstreetads.com/assets/images/featured-clients/baristanet.png" /></a></td>
                    <td><a href="http://thebatavian.com/"><img src="http://broadstreetads.com/assets/images/featured-clients/batavian.png" /></a></td>
                    <td><a href="http://arlnow.com/"><img src="http://broadstreetads.com/assets/images/featured-clients/arlingtonnow.png" /></a></td>
                    <td><a href="http://hulafrog.com/"><img src="http://broadstreetads.com/assets/images/featured-clients/hulafrog.png" /></a></td>
                </tr>
                <tr>
                    <td><a href="http://natomasbuzz.com/"><img src="http://broadstreetads.com/assets/images/featured-clients/natomas.png" /></a></td>
                    <td><a href="http://www.sheepsheadbites.com/"><img src="http://broadstreetads.com/assets/images/featured-clients/sheepshead.png" /></a></td>
                    <td><a href="http://www.pvpost.com/"><img src="http://broadstreetads.com/assets/images/featured-clients/pvpost.png" /></a></td>
                    <td><a href="http://njnewscommons.com/"><img src="http://broadstreetads.com/assets/images/featured-clients/njnewscommons.png" /></a></td>
                </tr>
            </table>
        </div>
        <div id="info">
            <h2>You will be able to see <strong>reports on ad views and clicks</strong>. And best of all,
                ads will be served using
                <a target="_blank" href="http://broadstreetads.com">Broadstreet Ads</a>' ultra-fast adserver.</h2>    
        </div>
        <div id="call-to-action">
            <form id="signup" action="?step=signup&status=agree" method="post">
                <?php if(!Broadstreet_Mini_Utility::getNetworkID()): ?>
                <input id="email" type="text" name="email" placeholder="your@email.com" value="<?php echo get_bloginfo('admin_email') ?>" />
                <a href="#" onclick="$('#signup').submit();" class="btn call-to-action">$5 / month. Click for an Instant Signup</a>
                <?php else: ?>
                <input type="hidden" name="resub" value="1" />
                <a href="#" onclick="$('#signup').submit();" class="btn call-to-action">$5 / month. Click to re-subscribe.</a>
                <?php endif; ?>
            </form>
        </div>
<?php require 'footer.php' ?>

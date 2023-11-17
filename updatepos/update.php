<?php

/************************************
*   @author         Mian Saleem     *
*   @package        POS3            *
*   @subpackage     update          *
************************************/

$installFile = '../POS';

if (is_file($installFile)) {
    $step = $_GET['step'] ?? '';
    switch ($step) {
        default: ?>
        <ul class="steps">
            <li class="active pk">Checklist</li>
            <li>Verify</li>
            <li class="last">Done!</li>
        </ul>
        <h3>Pre-update Checklist</h3>
        <?php
        $error = false;
        if (phpversion() < '7.0') {
            $error = true;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> Your PHP version is " . phpversion() . '! PHP 7.0 or higher required!</div>';
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> You are running PHP " . phpversion() . '</div>';
        }
        // if(!extension_loaded('mcrypt')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Mcrypt PHP extension missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> Mcrypt PHP extension loaded!</div>";}
        if (!extension_loaded('mysqli')) {
            $error = true;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> Mysqli PHP extension missing!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> Mysqli PHP extension loaded!</div>";
        }
        if (!extension_loaded('mbstring')) {
            $error = true;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> MBString PHP extension missing!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> MBString PHP extension loaded!</div>";
        }
        if (!extension_loaded('gd')) {
            echo "<div class='alert alert-error'><i class='icon-remove'></i> GD PHP extension missing!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> GD PHP extension loaded!</div>";
        }
        if (!extension_loaded('curl')) {
            $error = true;
            echo "<div class='alert alert-error'><i class='icon-remove'></i> CURL PHP extension missing!</div>";
        } else {
            echo "<div class='alert alert-success'><i class='icon-ok'></i> CURL PHP exention loaded!</div>";
        }
        ?>
        <div class="bottom">
            <?php if ($error) {
            ?>
            <a href="#" class="btn btn-primary disabled">Next Step</a>
            <?php
        } else {
            ?>
            <a href="index.php?step=0" class="btn btn-primary">Next Step</a>
            <?php
        } ?>
        </div>

        <?php
        break;
        case '0': ?>
        <ul class="steps">
            <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
            <li class="active">Verify</li>
            <li class="last">Done!</li>
        </ul>
        <h3>Verify your purchase</h3>
        <?php
        if ($_POST) {
            $code        = $_POST['code'];
            $username    = $_POST['username'];
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, 'https://api.tecdiary.com/v1/license/');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            $referer = 'http://' . $_SERVER['SERVER_NAME'] . substr($_SERVER['REQUEST_URI'], 0, -26);
            $path    = substr(realpath(dirname(__FILE__)), 0, -9);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, [
                'username' => $_POST['username'],
                'code'     => $_POST['code'],
                'id'       => '4494018',
                'ip'       => $_SERVER['REMOTE_ADDR'],
                'referer'  => $referer,
                'path'     => $path,
            ]);

            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);

            $object = json_decode($buffer);

            if ($object->status == 'success') {
                ?>
                <form action="index.php?step=1" method="POST" class="form-horizontal">

                    <div class="alert alert-success"><i class='icon-ok'></i> <strong><?php echo ucfirst($object->status); ?></strong>:<br /><?php echo $object->message; ?></div>
                    <input id="code" type="hidden" name="code" value="<?php echo $code; ?>" />
                    <input id="username" type="hidden" name="username" value="<?php echo $username; ?>" />
                    <div class="bottom">
                        <input type="submit" class="btn btn-primary" value="Next Step"/>
                    </div>
                </form>
                <?php
            } else {
                ?>
                <div class="alert alert-error"><i class='icon-remove'></i> <strong><?php echo ucfirst($object->status); ?></strong>:<br /> <?php echo $object->message; ?></div>
                <form action="index.php?step=0" method="POST" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="username">Envato Username</label>
                        <div class="controls">
                            <input id="username" type="text" name="username" class="input-large" required data-error="Username is required" placeholder="Envato Username" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="code">Purchase Code <a href="#myModal" role="button" data-toggle="modal"><i class="icon-question-sign"></i></a></label>
                        <div class="controls">
                            <input id="code" type="text" name="code" class="input-large" required data-error="Purchase Code is required" placeholder="Purchase Code" />
                        </div>
                    </div>
                    <div class="bottom">
                        <input type="submit" class="btn btn-primary" value="Check"/>
                    </div>
                </form>
                <?php
            }
        } else {
            ?>
            <p>Please enter the required information to register free support account and verify your purchase. </p><br>
            <form action="index.php?step=0" method="POST" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="username">Envato Username</label>
                    <div class="controls">
                        <input id="username" type="text" name="username" class="input-large" required data-error="Username is required" placeholder="Envato Username" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="code">Purchase Code <a href="#myModal" role="button" data-toggle="modal"><i class="icon-question-sign"></i></a></label>
                    <div class="controls">
                        <input id="code" type="text" name="code" class="input-large" required data-error="Purchase Code is required" placeholder="Purchase Code" />
                    </div>
                </div>
                <div class="bottom">
                    <input type="submit" class="btn btn-primary" value="Validate"/>
                </div>
            </form>
            <?php
        }
        break;
        case '1': ?>
        <ul class="steps">
            <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
            <li class="ok"><i class="icon icon-ok"></i>Verify</li>
            <li  class="active">Done!</li>
        </ul>

        <?php
        if ($_POST) {
            $code     = $_POST['code'];
            $username = $_POST['username'];
            define('BASEPATH', 'installpos/');
            include '../app/config/database.php';
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, 'https://api.tecdiary.com/v1/dbtables/');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, [
                'username' => $_POST['username'],
                'code'     => $_POST['code'],
                'id'       => '4494018',
                'version'  => '3.1',
                'type'     => 'update',
            ]);
            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);
            $object = json_decode($buffer);

            if ($object->status == 'success') {
                if (isset($object->database)) {
                    $dbdata = [
                        'hostname' => $db['default']['hostname'],
                        'username' => $db['default']['username'],
                        'password' => $db['default']['password'],
                        'database' => $db['default']['database'],
                        'dbtables' => $object->database,
                    ];
                    require_once 'includes/database_class.php';
                    $database = new Database();
                    if ($database->update_db($dbdata, $_POST['username'], $_POST['code']) == false) {
                        $finished = false;
                        echo "<div class='alert alert-error'><i class='icon-error'></i> The database tables could not be created, please try again.</div>";
                    } else {
                        $finished = true;
                        if (!@unlink('../POS')) {
                            echo "<div class='alert alert-warning'><i class='icon-warning'></i> Please remove the POS file from the main folder in order to lock the update tool.</div>";
                        }
                    }
                } else {
                    echo "<div class='alert alert-error'><i class='icon-remove'></i> " . $object->message . '</div>';
                }
            } else {
                echo "<div class='alert alert-error'><i class='icon-remove'></i> " . $object->message . '</div>';
            }
        }
        if ($finished) {
            ?>

            <h3><i class='icon-ok'></i> Update completed!</h3>
            <div class="alert alert-warning"><i class='icon-warning-sign'></i> You can proceed to login now.</div>
            <div class="bottom">
                <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . substr($_SERVER['REQUEST_URI'], 0, -26); ?>" class="btn btn-primary">Go to Login</a>
            </div>

            <?php
        }
    }
} else {
    echo "<div style='width: 100%; font-size: 10em; color: #757575; text-shadow: 0 0 2px #333, 0 0 2px #333, 0 0 2px #333; text-align: center;'><i class='icon-lock'></i></div><h3 class='alert-text text-center'>Update tool is locked!<br><small style='color:#666;'>Please contact your developer/support.</small></h3>";
}
?>


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
        <h3 id="myModalLabel">How to find your purchase code</h3>
    </div>
    <div class="modal-body">
        <img src="img/purchaseCode.png">
    </div>
</div>

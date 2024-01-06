<script type="text/javascript">
    function validation(evt) {
          
        var ASCII = (evt.which) ? evt.which : evt.keyCode
        if (ASCII > 31 && (ASCII < 48 || ASCII > 57) )
            return false;
        return true;
    }
</script>
<link rel="stylesheet" type="text/css" href="sample.css">
<div class="top-bar">
<style type="text/css">
  hr {
  border: 0;
  clear:both;
  display:block;
  width: 100%;               
  background-color:lightgray;
  opacity: 0.75;
  height: 2px;
}
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #1D2327;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: white;
  font-size: 12px;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}   
.dropdown-content a:hover {background-color: #444;}
.dropdown:hover .dropdown-content {display: block;}
</style>
                <div class="admin">
                    <div class="title">Admin Panel</div>
                </div>
                <div class="dropdown">
                            <div class="user">
                                <img src="img/MEI_new.png" alt="" style="border-radius: 50%;">
                            </div>

                        <div class="dropdown-content">
                            <a href="profile.php">Profile</a>
                            <hr>
                            <a href="logout.php">Logout</a>
                        </div>

                </div>

            </div>
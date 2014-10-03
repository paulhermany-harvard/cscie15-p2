<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Project 2 | CSCI E-15 Fall 2014 | Paul Hermany</title>
    
    <link rel="stylesheet" href="./css/lib/bootstrap-3.2.0.min.css"/>
    <link rel="stylesheet" href="./css/lib/bootstrapValidator-0.5.2.min.css"/>
    <link rel="stylesheet" href="./css/app.css"/>
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?php require 'index.config.php'; ?>
    <?php require 'index.logic.php'; ?>
    
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="http://p2.paulhermany.me">XKCD-Style Password Generator</a>
            </div>
        </div>
    </div>
 
    <div class="container">
        
        <div class="jumbotron">
            <h1 id="password"><?=$password;?></h1>
        </div>
        
        <form id="chbs" name="chbs" action="index.php" method="GET">
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg">Regenerate</button>
            </div>
            
            <!-- GRADE LEVEL -->
            <div class="form-group">
                <label for="<?=$gradeLevel_ParamName;?>"><?=$gradeLevel_Text;?></label>
                <select class="form-control" id="<?=$gradeLevel_ParamName;?>" name="<?=$gradeLevel_ParamName;?>[]" multiple="multiple">
                    <?php foreach($gradeLevel_Constraints['values'] as $key => $value): ?>
                    <option value="<?=$key;?>"
                        <?=(isset($gradeLevel[$key]) ? 'selected="selected"' : '');?>
                        data-rel-min="<?=$value[1];?>"
                        data-rel-max="<?=$value[2];?>"><?=$value[3];?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- WORD COUNT -->
            <div class="form-group">
                <label for="<?=$wordCount_ParamName;?>"><?=$wordCount_Text;?></label>
                <input class="form-control" id="<?=$wordCount_ParamName;?>" name="<?=$wordCount_ParamName;?>" type="number"
                    value="<?=$wordCount;?>"
                    min="<?=$wordCount_Constraints['min'];?>"
                    max="<?=$wordCount_Constraints['max'];?>"
                />
            </div>
            
            <!-- MINIMUM WORD LENGTH -->
            <div class="form-group">
                <label for="<?=$minLength_ParamName;?>"><?=$minLength_Text;?></label>
                <input class="form-control" id="<?=$minLength_ParamName;?>" name="<?=$minLength_ParamName;?>" type="number"
                    value="<?=$minLength;?>"
                    min="<?=$relMin;?>"
                    max="<?=$relMax;?>"
                    data-bv-lessthan-inclusive="true"
                    data-bv-lessthan-value="maxLength"
                    data-bv-lessthan-message="The minimum length must be less than or equal to the maximum length"
                />
            </div>
            
            <!-- MAXIMUM WORD LENGTH -->
            <div class="form-group">
                <label for="<?=$maxLength_ParamName;?>"><?=$maxLength_Text;?></label>
                <input class="form-control" id="<?=$maxLength_ParamName;?>" name="<?=$maxLength_ParamName;?>" type="number"
                    value="<?=$maxLength;?>"
                    min="<?=$relMin;?>"
                    max="<?=$relMax;?>"
                    data-bv-greaterthan-inclusive="true"
                    data-bv-greaterthan-value="minLength"
                    data-bv-greaterthan-message="The maximum length must be greater than or equal to the minimum length"
                />
            </div>
            
            <!-- SEPARATOR CHARACTER(S) -->
            <div class="form-group">
                <label for="<?=$separator_ParamName;?>"><?=$separator_Text;?></label>
                <input class="form-control" id="<?=$separator_ParamName;?>" name="<?=$separator_ParamName;?>" type="text"
                    value="<?=$separator;?>"
                    maxLength="<?=$separator_Constraints['maxLength'];?>"
                />
            </div>
            
            <!-- ADD COMPLEXITY -->
            <div class="form-group">
                <label>Complexity</label>
                <div class="checkbox">
                    <label>
                        <input id="<?=$complexity_add_ParamName;?>" name="<?=$complexity_add_ParamName;?>" type="checkbox" <?=($complexity_add == true ? 'checked="checked"' : '');?> />
                        <span><?=$complexity_add_Text;?></span>
                    </label>
                    <span>
                        <span><?=$complexity_a_random_Text;?></span>
                        <select name="<?=$complexity_a_random_ParamName;?>">
                            <?php foreach($complexity_a_random_Constraints['values'] as $key): ?>
                            <option value="<?=$key;?>" <?=($complexity_a_random == $key ? 'selected="selected"' : '');?> ><?=$key;?></option>
                            <?php endforeach; ?>
                        </select>
                        <span><?=$complexity_to_the_Text;?></span>
                        <select name="<?=$complexity_to_the_ParamName;?>">
                            <?php foreach($complexity_to_the_Constraints['values'] as $key): ?>
                            <option value="<?=$key;?>" <?=($complexity_to_the == $key ? 'selected="selected"' : '');?> ><?=$key;?></option>
                            <?php endforeach; ?>
                        </select>
                        <span><?=$complexity_of_Text;?></span>
                        <select name="<?=$complexity_of_ParamName;?>">
                            <?php foreach($complexity_of_Constraints['values'] as $key): ?>
                            <option value="<?=$key;?>" <?=($complexity_of == $key ? 'selected="selected"' : '');?> ><?=$key;?></option>
                            <?php endforeach; ?>
                        </select>
                    </span>                 
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg">Regenerate</button>
                <button type="button" class="btn btn-default btn-lg" onclick="window.location='index.php';">Reset</button>
            </div>
        </form>
        
        <h2>What is this?</h2>
        <p>This is a password generator inspired by <a href="http://xkcd.com/936/">"Password Strength"</a> by <a href="http://en.wikipedia.org/wiki/Randall_Munroe">Randall Monroe</a>. This comic appeared on his website <a href="http://xkcd.com/">http://xkcd.com</a> on August 10, 2011.</p>
        <img alt="XKCD Password Strength Comic" class="img-responsive" src="http://imgs.xkcd.com/comics/password_strength.png" />
        
    </div>

    <script type="text/javascript" src="./js/lib/require-2.1.15.min.js" data-main="./js/app.js"></script>
    
  </body>
</html>
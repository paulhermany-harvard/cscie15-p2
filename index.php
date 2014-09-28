<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Project 2 | CSCI E-15 Fall 2014 | Paul Hermany</title>
    
    <link rel="stylesheet" href="./css/lib/bootstrap-3.2.0.min.css"/>
    <link rel="stylesheet" href="./css/app.css"/>
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<?php require 'config.php'; ?>
	<?php require 'index.logic.php'; ?>
	
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="p2.paulhermany.me">XKCD-Style Password Generator</a>
			</div>
		</div>
    </div>
 
    <div class="container">
		
		<div class="jumbotron">
			<h2 class="password"><?=isset($password) ? $password : 'correct horse battery staple';?></h2>
		</div>
		
		<form action="index.php" method="GET">
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-lg">Regenerate</button>				
			</div>
			
			<h2>Advanced Settings</h2>
			
			<div class="form-group">
				<label for="<?=$FORM_GET_Key_wordCount;?>">Number of Words</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input id="<?=$FORM_GET_Key_wordCount;?>" name="<?=$FORM_GET_Key_wordCount;?>" type="number" class="form-control" min="1" max="<?=$MAX_WORDCOUNT;?>" value="<?=$m_wordCount;?>" />
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$FORM_GET_Key_wordCount;?>_Randomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="<?=$FORM_GET_Key_minLength;?>">Minimum Word Length</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input id="<?=$FORM_GET_Key_minLength;?>" name="<?=$FORM_GET_Key_minLength;?>" type="number" class="form-control" min="1" max="<?=$MAX_LENGTH;?>" value="<?=$m_minLength;?>" />
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$FORM_GET_Key_minLength;?>Randomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="<?=$FORM_GET_Key_maxLength;?>">Maximum Word Length</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input id="<?=$FORM_GET_Key_maxLength;?>" name="<?=$FORM_GET_Key_maxLength;?>" type="number" class="form-control" min="1" max="<?=$MAX_LENGTH;?>" value="<?=$m_maxLength;?>" />
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$FORM_GET_Key_maxLength;?>Randomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Grade Level</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<div class="form-control">
						<?php foreach($UI_gradeLevels as $key => $value): ?>
							<label class="checkbox-inline">
							  <input type="checkbox" id="<?=$FORM_GET_Key_gradeLevel.$key;?>" name="<?=$FORM_GET_Key_gradeLevel;?>[]" value="<?=$key;?>" <?=isset($m_gradeLevelArr[$key]) ? 'checked="checked"' : '';?> ><?=$value;?></input>
							</label>
						<?php endforeach; ?>
						</div>
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$FORM_GET_Key_gradeLevel;?>Randomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="<?=$FORM_GET_Key_separator;?>">Word Separator</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input id="<?=$FORM_GET_Key_separator;?>" name="<?=$FORM_GET_Key_separator;?>" type="text" class="form-control" value="<?=$m_separator;?>" />
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$FORM_GET_Key_separator;?>Randomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>

			<button type="submit" class="btn btn-primary btn-lg">Regenerate</button>
			<button type="reset" class="btn btn-default btn-lg">Reset</button>
		</form>
		
		<h2>What is this?</h2>
		<p>This is a password generator inspired by <a href="http://xkcd.com/936/">"Password Strength"</a> by <a href="http://en.wikipedia.org/wiki/Randall_Munroe">Randall Monroe</a>. This comic appeared on his website <a href="http://xkcd.com/">http://xkcd.com</a> on August 10, 2011.</p>
		<img alt="XKCD Password Strength Comic" class="img-responsive" src="http://imgs.xkcd.com/comics/password_strength.png" />
		
	</div>

    <script type="text/javascript" src="./js/lib/require-2.1.15.min.js" data-main="./js/app.js"></script>
    
  </body>
</html>
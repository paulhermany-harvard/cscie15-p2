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
			<h1 class="password"><?="correct horse battery staple";?></h1>
		</div>
		
		<form action="index.php" method="GET">
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-lg">Regenerate</button>				
			</div>
			
			<h2>Advanced Settings</h2>
			
			<div class="form-group">
				<label for="wordCount">Number of Words</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input id="wordCount" type="number" class="form-control" value="4" />
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="wordCountRandomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="minLength">Minimum Word Length</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input id="minLength" type="number" class="form-control" value="1" />
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="minLengthRandomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="maxLength">Maximum Word Length</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input id="maxLength" type="number" class="form-control" value="17" />
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="maxLengthRandomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Grade Level</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<div class="form-control">
						<?php
							$UI_gradeLevels = Array(
								'SAT' => 'SAT',
								'G8' => '8<sup>th</sup>',
								'G7' => '7<sup>th</sup>',
								'G6' => '6<sup>th</sup>',
								'G5' => '5<sup>th</sup>',
								'G4' => '4<sup>th</sup>',
								'G3' => '3<sup>rd</sup>',
								'G2' => '2<sup>nd</sup>',
								'G1' => '1<sup>st</sup>'
							);
						?>
						<?php foreach($UI_gradeLevels as $key => $value): ?>
							<label class="checkbox-inline">
							  <input type="checkbox" id="gradeLevel<?=$key;?>" value="<?=$key;?>"><?=$value;?>
							</label>
						<?php endforeach; ?>
						</div>
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="gradeLevelRandomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="wordSeparator">Word Separator</label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input id="wordSeparator" type="text" class="form-control" value=" " />
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="wordSeparatorRandomize" type="button" class="btn btn-default">Randomize</button>
					</div>
				</div>
			</div>

			<button type="submit" class="btn btn-primary btn-lg">Regenerate</button>
		</form>
		
		<h2>What is this?</h2>
		<p>This is a password generator inspired by <a href="http://xkcd.com/936/">"Password Strength"</a> by <a href="http://en.wikipedia.org/wiki/Randall_Munroe">Randall Monroe</a>. This comic appeared on his website <a href="http://xkcd.com/">http://xkcd.com</a> on August 10, 2011.</p>
		<img alt="XKCD Password Strength Comic" class="img-responsive" src="http://imgs.xkcd.com/comics/password_strength.png" />
		
	</div>

    <script type="text/javascript" src="./js/lib/require-2.1.15.min.js" data-main="./js/app.js"></script>
    
  </body>
</html>
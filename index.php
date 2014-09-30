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
	<?php require 'chbs.config.php'; ?>
	
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
			<h2 id="password">correct horse battery staple</h2>
		</div>
		
		<form id="chbs" name="chbs" action="chbs.php" method="POST">
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-lg">Regenerate</button>				
			</div>
			
			<h2>Advanced Settings</h2>
			
			<div class="form-group">
				<label for="<?=$m_wordCount_ParamName;?>"><?=$UI_wordCount_Text;?></label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input
							id="<?=$m_wordCount_ParamName;?>"
							name="<?=$m_wordCount_ParamName;?>"
							value="<?=$m_wordCount_Constraints['default'];?>"
							class="form-control error"
							type="number"
							min="<?=$m_wordCount_Constraints['min'];?>"
							max="<?=$m_wordCount_Constraints['max'];?>"
						/>
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$m_wordCount_ParamName;?>_Randomize" type="button" class="btn btn-default"><?=$UI_randomize_Text;?></button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="<?=$m_minLength_ParamName;?>"><?=$UI_minLength_Text;?></label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input
							id="<?=$m_minLength_ParamName;?>" 
							name="<?=$m_minLength_ParamName;?>" 
							value="<?=$m_minLength_AbsoluteMin;?>"
							class="form-control"
							type="number" 							
							min="<?=$m_minLength_AbsoluteMin;?>"
							max="<?=$m_maxLength_AbsoluteMax;?>"
						/>
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$m_minLength_ParamName;?>_Randomize" type="button" class="btn btn-default"><?=$UI_randomize_Text;?></button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="<?=$m_maxLength_ParamName;?>"><?=$UI_maxLength_Text;?></label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input 
							id="<?=$m_maxLength_ParamName;?>"
							name="<?=$m_maxLength_ParamName;?>"
							value="<?=$m_maxLength_AbsoluteMax;?>"
							class="form-control"
							type="number"
							min="<?=$m_minLength_AbsoluteMin;?>"
							max="<?=$m_maxLength_AbsoluteMax;?>"
						/>
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$m_maxLength_ParamName;?>_Randomize" type="button" class="btn btn-default"><?=$UI_randomize_Text;?></button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label><?=$UI_gradeLevel_Text;?></label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<div class="form-control">
						<?php foreach($UI_gradeLevels as $key => $value): ?>
							<label class="checkbox-inline">
								<input
									id="<?=$m_gradeLevel_ParamName.$key;?>"
									name="<?=$m_gradeLevel_ParamName;?>[]"
									value="<?=$key;?>"
									type="checkbox" 
									checked="checked" 
									data-rel-min="<?=$m_gradeLevel_Stats[$key][1];?>" 
									data-rel-max="<?=$m_gradeLevel_Stats[$key][2];?>">
									<span><?=$value;?></span>
								</input>
							</label>
						<?php endforeach; ?>
						</div>
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$m_gradeLevel_ParamName;?>_Randomize" type="button" class="btn btn-default"><?=$UI_randomize_Text;?></button>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="<?=$m_separator_ParamName;?>"><?=$UI_separator_Text;?></label>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<input
							id="<?=$m_separator_ParamName;?>"
							name="<?=$m_separator_ParamName;?>"
							type="text"
							class="form-control"
							value="<?=$m_separator_Constraints['default'];?>"
						/>
					</div>
					<div class="col-sm-2 col-xs-4">
						<button id="<?=$m_separator_ParamName;?>_Randomize" type="button" class="btn btn-default"><?=$UI_randomize_Text;?></button>
					</div>
				</div>
			</div>

			<button type="submit" class="btn btn-primary btn-lg"><?=$UI_regenerate_Text;?></button>
			<button type="reset" class="btn btn-default btn-lg"><?=$UI_reset_Text;?></button>
		</form>
		
		<h2>What is this?</h2>
		<p>This is a password generator inspired by <a href="http://xkcd.com/936/">"Password Strength"</a> by <a href="http://en.wikipedia.org/wiki/Randall_Munroe">Randall Monroe</a>. This comic appeared on his website <a href="http://xkcd.com/">http://xkcd.com</a> on August 10, 2011.</p>
		<img alt="XKCD Password Strength Comic" class="img-responsive" src="http://imgs.xkcd.com/comics/password_strength.png" />
		
	</div>

    <script type="text/javascript" src="./js/lib/require-2.1.15.min.js" data-main="./js/app.js"></script>
    
  </body>
</html>
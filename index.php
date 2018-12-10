<?php
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

$plugin_slug = 'auto-load-next-post';
$plugin_name = 'Auto Load Next Post';

$stats = get_data('https://api.wordpress.org/plugins/info/1.0/' . $plugin_slug . '.json');
$downloads = json_decode($stats, true);
?>
<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content="charset=utf-8">
	<title><?php echo $plugin_name; ?> Download Counter</title>
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<style type="text/css">
	html,
	body {
		height: 100%;
		margin: 0;
	}

	body {
		color: #464646;
		font-family: "Open Sans", sans-serif;
		font-weight: 300;
		font-size: 1em;
		background: #f1f1f1;
	}

	a {
		color: #0074a2;
		font-size: 0.7em;
		text-decoration: none;
	}

	a:hover {
		color: #2ea2cc;
	}

	h2 {
		font-weight: normal;
	}

	#numnumnum, #numnumnum2 {
		color: #2ea2cc;
		font-family: Georgia, "Times New Roman", Times, serif;
		margin: 0 auto;
		position: absolute;
		left: 0;
		right: 0;
		text-align: center;
		width: 100%;
	}

	#numnumnum2 {
		display: none;
	}

	#wrap {
		color: black;
		height: 1.35em;
		font-size: 2em;
		font-weight: normal;
		margin: 0.25em 0;
	}

	.something-semantic {
		display: table;
		height: 100%;
		width: 100%;
	}

	.something-else-semantic {
		display: table-cell;
		text-align: center;
		vertical-align: middle;
	}

	.counter-inner {
		border: 1px solid #e5e5e5;
		-webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.04);
		box-shadow: 0 1px 1px rgba(0,0,0,0.04);
		background: #fff;
		margin: 0 4%;
		padding: 6% 10%;
	}

	@media screen and (min-width: 360px) and (min-height: 400px) {
		body {
			font-size: 125%;
		}
	}

	@media screen and (min-width: 500px) and (min-height: 400px) {
		body {
			font-size: 150%;
		}
	}

	@media screen and (min-width: 600px) and (min-height: 500px) {
		body {
			font-size: 175%;
		}
	}

	@media screen and (min-width: 700px) and (min-height: 700px) {
		body {
			font-size: 200%;
		}
	}

	@media screen and (min-width: 900px) and (min-height: 900px) {
		body {
			font-size: 225%;
		}
		#wrap {
			font-size: 2.5em;
		}
	}

	@media screen and (min-width: 1200px) and (min-height: 1000px) {
		body {
			font-size: 300%;
		}
		.counter-inner {
			padding: 4% 10%;
		}
	}

	@media screen and (min-width: 1800px) and (min-height: 1200px) {
		body {
			font-size: 350%;
		}
		.counter-inner {
			padding: 4% 10%;
		}
	}
	</style>
	</head>

	<body>
		<div class="something-semantic">
			<div class="something-else-semantic">
				<div class="counter-inner">
					<h2><?php echo $plugin_name; ?> has been&nbsp;downloaded
					<div id="wrap">
						<span id="numnumnum" style="position: absolute; display: block;"><?php echo $downloads['downloaded']; ?></span>
						<span id="numnumnum2" style="position: absolute; display: none;"><?php echo $downloads['downloaded']; ?></span>
					</div>
					times</h2>
					<p>
						<a href="https://autoloadnextpost.com/?utm_source=autoloadnextpost-download-counter&utm_medium=link&utm_campaign=after-download-counter">← Back to <?php echo $plugin_name; ?></a>
					</p>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript">
		jQuery( function($) {
			var numnums   = $('#numnumnum, #numnumnum2'),
				numnumpos = $('#numnumnum').position(),
				dataLen   = $('#numnumnum').text().length;

			recenter = function( data ) {
				var visible = numnums.filter( ':visible' );

				visible.fadeOut( 500 ).queue( function() {
					visible.css( {
						position: 'absolute',
						display: 'inline',
						visibility: 'hidden',
					} ).html( data );

					numnumpos = visible.position();

					numnums.css( {
						position: 'absolute',
						display: 'none',
						visibility: 'visible',
					} );

				visible.dequeue();
			} ).fadeIn( 350 );
		};

		numnums.css( {
			position: 'absolute',
		} );

		setInterval(function() {
			$.post( 'dl-counter.php', function( data ) {
				if ( data.length != dataLen ) {
					recenter( data );
					dataLen = data.length;
				} else {
					if ( $('#numnumnum2').is(':hidden') ) {
						$('#numnumnum').fadeOut(500);
						$('#numnumnum2').html( data ).fadeIn(350);
					} else {
						$('#numnumnum2').fadeOut(500);
						$('#numnumnum').html( data ).fadeIn(350);
					}
				}
			});
		}, 4000);
	} );
	</script>

	</body>
</html>
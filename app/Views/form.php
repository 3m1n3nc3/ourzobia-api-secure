

<style {csp-style-nonce}>
	* {
		transition: background-color 300ms ease, color 300ms ease;
	}
	*:focus {
		background-color: rgba(221, 72, 20, .2);
		outline: none;
	}
	html, body {
		color: rgba(33, 37, 41, 1);
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
		font-size: 16px;
		margin: 0;
		padding: 0;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		text-rendering: optimizeLegibility;
	}
	header {
		background-color: rgba(247, 248, 249, 1);
		padding: .4rem 0 0;
	}
	.menu {
		padding: .4rem 2rem;
	}
	header ul {
		border-bottom: 1px solid rgba(242, 242, 242, 1);
		list-style-type: none;
		margin: 0;
		overflow: hidden;
		padding: 0;
		text-align: right;
	}
	header li {
		display: inline-block;
	}
	header li a {
		border-radius: 5px;
		color: rgba(0, 0, 0, .5);
		display: block;
		height: 44px;
		text-decoration: none;
	}
	header li.menu-item a {
		border-radius: 5px;
		margin: 5px 0;
		height: 38px;
		line-height: 36px;
		padding: .4rem .65rem;
		text-align: center;
	}
	header li.menu-item a:hover,
	header li.menu-item a:focus {
		background-color: rgba(221, 72, 20, .2);
		color: rgba(221, 72, 20, 1);
	}
	header .logo {
		float: left;
		height: 44px;
		padding: .4rem .5rem;
	}
	header .menu-toggle {
		display: none;
		float: right;
		font-size: 2rem;
		font-weight: bold;
	}
	header .menu-toggle button {
		background-color: rgba(221, 72, 20, .6);
		border: none;
		border-radius: 3px;
		color: rgba(255, 255, 255, 1);
		cursor: pointer;
		font: inherit;
		font-size: 1.3rem;
		height: 36px;
		padding: 0;
		margin: 11px 0;
		overflow: visible;
		width: 40px;
	}
	header .menu-toggle button:hover,
	header .menu-toggle button:focus {
		background-color: rgba(221, 72, 20, .8);
		color: rgba(255, 255, 255, .8);
	}
	header .heroe {
		margin: 0 auto;
		max-width: 1100px;
		padding: 1rem 1.75rem 1.75rem 1.75rem;
	}
	header .heroe h1 {
		font-size: 2.5rem;
		font-weight: 500;
	}
	header .heroe h2 {
		font-size: 1.5rem;
		font-weight: 300;
	}
	section {
		margin: 0 auto;
		max-width: 1100px;
		padding: 2.5rem 1.75rem 3.5rem 1.75rem;
	}
	section h1 {
		margin-bottom: 2.5rem;
	}
	section h2 {
		font-size: 120%;
		line-height: 2.5rem;
		padding-top: 1.5rem;
	}
	section pre {
		background-color: rgba(247, 248, 249, 1);
		border: 1px solid rgba(242, 242, 242, 1);
		display: block;
		font-size: .9rem;
		margin: 2rem 0;
		padding: 1rem 1.5rem;
		white-space: pre-wrap;
		word-break: break-all;
	}
	section code {
		display: block;
	}
	section a {
		color: rgba(221, 72, 20, 1);
	}
	section svg {
		margin-bottom: -5px;
		margin-right: 5px;
		width: 25px;
	}
	.further {
		background-color: rgba(247, 248, 249, 1);
		border-bottom: 1px solid rgba(242, 242, 242, 1);
		border-top: 1px solid rgba(242, 242, 242, 1);
	}
	.further h2:first-of-type {
		padding-top: 0;
	}
	footer {
		background-color: rgba(221, 72, 20, .8);
		text-align: center;
	}
	footer .environment {
		color: rgba(255, 255, 255, 1);
		padding: 2rem 1.75rem;
	}
	footer .copyrights {
		background-color: rgba(62, 62, 62, 1);
		color: rgba(200, 200, 200, 1);
		padding: .25rem 1.75rem;
	}
	@media (max-width: 559px) {
		header ul {
			padding: 0;
		}
		header .menu-toggle {
			padding: 0 1rem;
		}
		header .menu-item {
			background-color: rgba(244, 245, 246, 1);
			border-top: 1px solid rgba(242, 242, 242, 1);
			margin: 0 15px;
			width: calc(100% - 30px);
		}
		header .menu-toggle {
			display: block;
		}
		header .hidden {
			display: none;
		}
		header li.menu-item a {
			background-color: rgba(221, 72, 20, .1);
		}
		header li.menu-item a:hover,
		header li.menu-item a:focus {
			background-color: rgba(221, 72, 20, .7);
			color: rgba(255, 255, 255, .8);
		}
	}
	.form-group {
	    margin-bottom: 1rem;
	}
	label {
	    display: inline-block;
	    margin-bottom: .5rem;
	}
	.form-control {
	    display: block;
	    width: 100%;
	    padding: .375rem .75rem;
	    font-size: 1rem;
	    line-height: 1.5;
	    color: #495057;
	    background-color: #fff;
	    background-clip: padding-box;
	    border: 1px solid #ced4da;
	    border-radius: .25rem;
	    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
	button, input {
	    overflow: visible;
	}
	button, input, optgroup, select, textarea {
	    margin: 0;
	    font-family: inherit;
	    font-size: inherit;
	    line-height: inherit;
	}
	*, ::after, ::before {
	    box-sizing: border-box;
	}
	.text-muted {
	    color: #6c757d!important;
	}
	.form-text {
	    display: block;
	    margin-top: .25rem;
	}
	.small, small {
	    font-size: 80%;
	    font-weight: 400;
	}
	.btn:not(:disabled):not(.disabled) {
	    cursor: pointer;
	}
	.btn-primary {
	    color: #fff;
	    background-color: #007bff;
	    border-color: #007bff;
	}
	input[type="text"], input[type="password"], input[type="email"] {
	    height: 54px;
	    padding: 0 18px;
	    width: 100%;
	    border-radius: 12px;
	    font-size: 14px;
	    font-weight: 500;
	    background-color: #fff;
	    border: 1px solid #dedeea;
	    color: #3e3f5e;
	    transition: border-color .2s ease-in-out;
	}
	.btn {
	    display: inline-block;
	    font-weight: 400;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: middle;
	    -webkit-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	    border: 1px solid transparent;
	    padding: .375rem .75rem;
	    font-size: 1rem;
	    line-height: 1.5;
	    border-radius: .25rem;
	    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
	[type=reset], [type=submit], button, html [type=button] {
	    -webkit-appearance: button;
	}
	button, select {
	    text-transform: none;
	}
	button, input {
	    overflow: visible;
	}
	button, input, optgroup, select, textarea {
	    margin: 0;
	    font-family: inherit;
	    font-size: inherit;
	    line-height: inherit;
	}
	button {
	    border-radius: 0;
	}	
	.card {
	    position: relative;
	    display: -webkit-box;
	    display: -ms-flexbox;
	    display: flex;
	    -webkit-box-orient: vertical;
	    -webkit-box-direction: normal;
	    -ms-flex-direction: column;
	    flex-direction: column;
	    min-width: 0;
	    word-wrap: break-word;
	    background-color: #fff;
	    background-clip: border-box;
	    border: 1px solid rgba(0,0,0,.125);
	    border-radius: .25rem;
	}
	.card-body {
	    -webkit-box-flex: 1;
	    -ms-flex: 1 1 auto;
	    flex: 1 1 auto;
	    padding: 1.25rem;
	}
	.text-info {
	    color: #17a2b8!important;
	}
	.mb-5, .my-5 {
	    margin-bottom: 3rem!important;
	}
</style>
 
<section>
	<div class="card carder">
		<div class="card-body">
			<h1>Activate your Installation to continue using</h1>
			<div class="notificationbox"></div>
			
			<h5 class="text-info mb-5">Please enter the details from your purchase point.</h5>

			<?=form_open('requests/activate', ['id'=>'product_activation_form'])?>
			<div class="form-group">
				<label for="activation_email">Email address</label>
				<input type="email" class="form-control" name="email" id="activation_email" aria-describedby="emailHelp" placeholder="Enter email">
				<small id="emailHelp" class="form-text text-muted">This is the email address used during purchase.</small>
			</div>
			<div class="form-group">
				<label for="activation_code">Purchase Code</label>
				<input type="text" class="form-control" name="code" id="activation_code" placeholder="Purchase Code">
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
			<?=form_close()?>
		</div>
	</div>

</section>  

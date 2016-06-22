<h1>{{ title }}</h1>
{{ projects }}
	<h3>{{ name }}</h3>
	<h4>Assignees</h4>
	<ul>
	{{ assignees }}
		<li>{{lex.lower}}{{name}}{{/lex.lower}}</li>
	{{ /assignees }}
	</ul>
{{ /projects }}
<h1>{{ title }}</h1>
{{ projects }}
	<h3>{{ name }}</h3>
	<h4>Assignees</h4>
	<ul>
	{{ assignees }}
		<li>{{ name }}</li>
	{{ /assignees }}
	</ul>
{{ /projects }}
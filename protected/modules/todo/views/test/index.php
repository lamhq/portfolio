<?php

use \yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Schedule';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="buttons">
	<span class="btn-group">
		<button type="button" class="btn btn-info">Add Schedule</button>
		<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li><a href="#">For Plan</a></li>
			<li><a href="#">For Event</a></li>
			<li><a href="#">For Action</a></li>
		</ul>
	</span>
</div>

<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="javascript:void(0)">Date</a></li>
		<li><a href="#">Week</a></li>
		<li><a href="#">Month</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active">
			<div class="todo-calendar">
				<h4 class="calendar-title">Week 1 - Sep 2015</h4>
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th>
								<div class="dow">MON</div>
								<div class="dom">31</div>
							</th>
							<th>
								<div class="dow">TUE</div>
								<div class="dom">1</div>
							</th>
							<th>
								<div class="dow">WED</div>
								<div class="dom">2</div>
							</th>
							<th>
								<div class="dow">THU</div>
								<div class="dom">3</div>
							</th>
							<th>
								<div class="dow">FRI</div>
								<div class="dom">4</div>
							</th>
							<th>
								<div class="dow">SAT</div>
								<div class="dom">5</div>
							</th>
							<th>
								<div class="dow">SUN</div>
								<div class="dom">6</div>
							</th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<span class="time-anchor" style="top: 6.333%;" >02:00</span>
								<span class="time-anchor" style="top: 14.667%;" >04:00</span>
							</td>
							<td>
								<hr style="top: 8.333%;" />
								<hr style="top: 16.667%;" />
								<hr style="top: 25%;" />
								<hr style="top: 33.333%;" />
								<hr style="top: 41.667%;" />
								<hr style="top: 50.000%;" />
								<hr style="top: 58.333%;" />
								<hr style="top: 66.667%;" />
								<hr style="top: 75.000%;" />
								<hr style="top: 83.333%;" />
								<hr style="top: 91.667%;" />

								<div class="task" style="top: 50%;height: 15%; background-color: #2c82c9;">Todo list template</div>
							</td>
							<td>
								<div class="task" style="top: 0%;height: 100%; background-color: #50d07d;">National day</div>
							</td>
							<td>
								<hr style="top: 8.333%;" />
								<hr style="top: 16.667%;" />
								<hr style="top: 25%;" />
								<hr style="top: 33.333%;" />
								<hr style="top: 41.667%;" />
								<hr style="top: 50.000%;" />
								<hr style="top: 58.333%;" />
								<hr style="top: 66.667%;" />
								<hr style="top: 75.000%;" />
								<hr style="top: 83.333%;" />
								<hr style="top: 91.667%;" />
							</td>
							<td></td>
							<td></td>
							<td>
								<div class="task" style="top: 30%;height: 20%; background-color: #d02552;">National day</div>
							</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="task-list">
				<h4>Today, Sep 1</h4>
				<ol>
					<li>
						<button type="button" class="btn-check"><i class="fa fa-check-circle"></i></button>
						<span class="task-name">Todo project / Schedule page / Todo list template</span>
						<time class="task-time" datetime="2015-09-01 10:00+07:00">10:00 AM</time>
					</li>
					<li>
						<button type="button" class="btn-check"><i class="fa fa-check-circle"></i></button>
						<span class="task-name">Discuss property info logic with Zan zan</span>
						<time class="task-time" datetime="2015-09-02 13:00+07:00">01:00 PM</time>
					</li>
				</ol>
				<h4>Tommorow, Sep 2</h4>
				<ol>
					<li>
						<button type="button" class="btn-check"><i class="fa fa-check-circle"></i></button>
						<span class="task-name">National day</span>
						<time class="task-time" datetime="2015-09-02 13:00+07:00">01:00 PM</time>
					</li>
					<li>
						<button type="button" class="btn-check"><i class="fa fa-check-circle"></i></button>
						<span class="task-name">Todo project / Schedule page / Todo list template</span>
						<time class="task-time" datetime="2015-09-01 10:00+07:00">10:00 AM</time>
					</li>
				</ol>
				<h4>Thu, Sep 3</h4>
				<h4>Mon, Jan 3 2016</h4>
			</div>
			
			<div class="checkbox">
				<label><input type="checkbox"/> Show completed tasks.</label>
			</div>
			<p>
				<button type="button" class="btn btn-default">Today</button>
			</p>
		</div><!-- /.tab-pane -->
	</div>
	<!-- /.tab-content -->
</div>

<style>
.buttons {
	margin-bottom: 10px;
}

.task-list {
  border: 1px solid #ddd;
  border-bottom: none;
  margin-bottom: 10px;
}

.task-list h4 {
  background-color: #f1f1f1;
  border-bottom: 1px solid #ddd;
  font-size: 16px;
  margin: 0;
  padding: 6px;
}

.task-list ol {
  list-style: none;
  padding: 0;
  margin: 0;
}

.task-list li {
  border-bottom: 1px solid #ddd;
  padding: 6px;
}

.btn-check {
  background: none;
  border: none;
  font-size: 25px;
}

.task-list .btn-check {
	float: left;
}

.task-time, .task-name {
  display: block;
  margin-left: 39px;
}

.task-time {
  color: #ccc;
  font-size: 13px;
  font-style: italic;
}

.calendar-title {
  text-align: center;
}

.todo-calendar th {
	text-align: center;
}

.todo-calendar td {
  height: 500px;
  position: relative;
}

.todo-calendar .task {
	color: white;
	padding: 3px 5px;
	position: absolute;
	width: 100%;
}

.todo-calendar hr {
  border-top: 1px solid #f4f4f4;
  margin: 0;
  position: absolute;
  width: 100%;
}

.todo-calendar .time-anchor {
  position: absolute;
  color: #888888;
}

.todo-calendar table {
  margin-bottom: 20px;
  width: 100%;
}

.todo-calendar thead > tr > th {
  border-bottom: 2px solid #f4f4f4;
  vertical-align: bottom;
  line-height: 1.42857;
  padding: 8px;
  vertical-align: bottom;
}
</style>
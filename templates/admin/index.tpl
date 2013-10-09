{include file="header_admin.tpl"}
<header id="header">
	系统设置
</header>
<div id="popwindow-container">
	<section id="popwindow">
		<div id="popcontent">
			<div id="top_nav">
				<header>添加首页头部</header>
				<table class="list">
					<thead>
						<tr>
							<td>名称</td>
							<td>链接地址</td>
							<td>排序权重</td>
						</tr>
					</thead>
				</table>

			<div class="create">
				<form>
					<p>
						<label for="top_nav_name">名称</label>
						<input id="top_nav_name" name="name">
					</p>
					<p>
						<label for="top_nav_url">链接地址</label>
						<input id="top_nav_url" name="url">
					</p>
					<p>
						<label for="top_nav_rankid">排序权重</label>
						<input id="top_nav_rankid" name="rankid">
					</p>
					<p>
						<button id="top_nav_new">新增</button>
						<button id="top_nav_edit">修改</button>
					</p>
				</form>
			</div>
			</div>

			<div id="bottom_left">
				<header>首页底部左侧</header>
				<table class="list">
					<thead>
						<tr>
							<td>名称</td>
							<td>排序权重</td>
						</tr>
					</thead>
				</table>

			<div class="create">
				<form>
					<p>
						<label for="bottom_left_name">名称</label>
						<input id="bottom_left_name" name="name">
					</p>
					<p>
						<label for="bottom_left_content">内容</label>
						<textarea id="bottom_left_content" name="content"></textarea>
					</p>
					<p>
						<label for="bottom_left_rankid">排序权重</label>
						<input id="bottom_left_rankid" name="rankid">
					</p>
					<p>
						<button id="bottom_left_new">新增</button>
						<button id="bottom_left_edit">修改</button>
					</p>
				</form>
			</div>
			</div>

			<div id="bottom_right">
				<header>首页底部右侧</header>
				<table class="list">
					<thead>
						<tr>
							<td>名称</td>
							<td>链接地址</td>
							<td>排序权重</td>
						</tr>
					</thead>
				</table>

			<div class="create">
				<form>
					<p>
						<label for="bottom_right_name">名称</label>
						<input id="bottom_right_name" name="name">
					</p>
					<p>
						<label for="bottom_right_url">链接地址</label>
						<input id="bottom_right_url" name="url">
					</p>
					<p>
						<label for="bottom_right_rankid">排序权重</label>
						<input id="bottom_right_rankid" name="rankid">
					</p>
					<p>
						<button id="bottom_right_new">新增</button>
						<button id="bottom_right_edit">修改</button>
					</p>
				</form>
			</div>
			</div>

		</div>
	</section>
</div>
<section id="content_warpper">
	<section id="content">
		<div class="col">
			<div class="line">
				<div class="block1" id="top_nav_controller">顶部链接</div>
				<div class="block1" id="bottom_left_controller">底部左侧</div>
			</div>
			<div class="line">
				<div class="block2" id="bottom_right_controller">底部右侧</div>
			</div>
			<div class="line">
				<div class="block2"></div>
			</div>
			<div class="line">
				<div class="block1"></div>
				<div class="block1"></div>
			</div>
		</div>

		<div class="col">
			<div class="line">
				<div class="block1">

				</div>
				<div class="block1"></div>
			</div>
			<div class="line">
				<div class="block2"></div>
			</div>
			<div class="line">
				<div class="block2"></div>
			</div>
			<div class="line">
				<div class="block1"></div>
				<div class="block1"></div>
			</div>
		</div>

		<div class="col">
			<div class="line">
				<div class="block1"></div>
				<div class="block1"></div>
			</div>
			<div class="line">
				<div class="block2"></div>
			</div>
			<div class="line">
				<div class="block1"></div>
				<div class="block1"></div>
			</div>
		</div>
	</section>
</section>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/admin.js"></script>
{include file="footer_admin.tpl"}
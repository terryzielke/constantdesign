<?php get_header(); ?>



<table>
	<tr>
		<td>Template</td>
		<td>archive.php</td>
	</tr>
	<tr>
		<td>Title</td>
		<td><?=get_the_archive_title()?></td>
	</tr>
</table>



<?php if(have_posts()){ ?>
	<?php while(have_posts()){ the_post(); ?>
		<table>
			<tr>
				<td>ID</td>
				<td><?=get_the_ID()?></td>
			</tr>
			<tr>
				<td>Date</td>
				<td><?=get_the_date()?></td>
			</tr>
			<tr>
				<td>Title</td>
				<td><?=get_the_title()?></td>
			</tr>
			<tr>
				<td>Url</td>
				<td><a href="<?=get_the_permalink()?>"><?=get_the_permalink()?></a></td>
			</tr>
			<tr>
				<td>Category</td>
				<td><?=get_the_category_list()?></td>
			</tr>
			<tr>
				<td>Tag</td>
				<td><?=get_the_tag_list()?></td>
			</tr>
			<tr>
				<td>Author</td>
				<td><?=get_the_author_posts_link()?></td>
			</tr>
			<tr>
				<td>Summary</td>
				<td><?=get_the_excerpt()?></td>
			</tr>
			
			<?php if(has_post_thumbnail()){ ?>
				<tr>
					<td>Image Element</td>
					<td><?=the_post_thumbnail('thumbnail')?></td>
				</tr>
				<tr>
					<td>Image Url</td>
					<td><a href="<?=get_the_post_thumbnail_url(null, 'full')?>"><?=get_the_post_thumbnail_url(null, 'thumbnail')?></a></td>
				</tr>
			<?php } ?>
		</table>
	<?php } ?>
<?php }else{ ?>

	No posts found.
	
<?php } ?>



<?php if($wp_query->max_num_pages > 1){ ?>
	<table>
		<tr>
			<td>Pagination</td>
			<td><?=get_the_posts_pagination([				
				'mid_size' => 5,
				'prev_text' => '⇠',
				'next_text' => '⇢'
			])?></td>
		</tr>
	</table>
<?php } ?>



<?php get_footer(); ?>
       <?php  
       if ($mail_id) 
       {
            foreach ($email->replyTo as $replyTo => $rt) {}
       }?>

					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">Compose New Message</h3> 
						</div>

						<?=form_open()?>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="form-group">
								<input class="form-control selectize" placeholder="To:" name="recipients" value="<?=set_value('recipients', $recipients)?>" data-recipients='<?="[{\"title\": \"".implode("\"},\n{\"title\": \"",array_values(explode(',', set_value('recipients', $recipients))))."\"}]"?>' required>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Subject:" name="subject" value="<?=set_value('subject', $head->subject ?? '')?>" required>
							</div>
							<div class="form-group">
								<textarea id="compose-textarea" class="form-control textarea" name="message" required><?=set_value('message', $email->textHtml ?? ($email->textPlain ?? ''))?></textarea>
							</div>
						<!-- 	<div class="form-group">
								<div class="btn btn-default btn-file">
									<i class="fas fa-paperclip"></i> Attachment
									<input type="file" name="attachment">
								</div>
								<p class="help-block">Max. 32MB</p>
							</div> -->
						</div>
						<!-- /.card-body -->
						<div class="card-footer">
							<div class="float-right">
								<button type="submit" class="btn btn-default" name="action" value="draft">
									<i class="fas fa-pencil-alt"></i> Draft
								</button>
								<button type="submit" class="btn btn-primary" name="action" value="send">
									<i class="far fa-envelope"></i> Send
								</button>
							</div>
							<a href="<?=site_url("mail/compose/?csrf=" . csrf_hash())?>" class="btn btn-default"><i class="fas fa-times"></i> Discard</a>
						</div>
						<!-- /.card-footer -->
						<?=form_close();?>
					</div>

					<script>
					    window.onload = function() { 
					        $(".selectize").each(function(e) { 
					            $(this).selectize({
					                plugins: ['drag_drop', 'remove_button', 'restore_on_backspace'], 
					                delimiter: ',',
					                persist: false,
					                hideSelected: true,
					                valueField: 'title',
					                searchField: 'title',
					                options: $(this).data("recipients"),
					                render: {
					                    option: function(data, escape) {
					                        return '<div class="title pl-1">' + escape(data.title) + '</div>';
					                    },
					                    item: function(data, escape) {
					                        return '<div class="item">' + escape(data.title) + '</div>';
					                    }
					                },
					                create: function(input) { 
					                    return { 
					                        title: input 
					                    }
					                }
					            }); 
					        });
					    }
					</script> 
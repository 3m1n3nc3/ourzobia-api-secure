    <?php if (in_array($content['safelink'], ['blog', 'posts', 'events'])): ?>
        <?php if (!empty($post['post_id'])): ?>
            <?=load_widget('posts/single', ['post'=>$post], 'front');?>
        <?php else: ?>
        <section id="blog" class="section">
            <div class="container"> 
                <div class="row">
            <?php
                $i = 0;
                if (!empty($posts)): 
                    foreach ($posts as $key => $post): 
                        $i++?>  
                        <?=load_widget('posts/item', ['post'=>$post], 'front');?>
                <?php endforeach;?>
                <?php if (my_config('pagination', null, 'click') === 'click'): ?>
                    <?=$pager->simpleLinks('default', 'custom_full') ?>
                <?php endif ?>
            <?php else: ?>
                <div class="col-12 text-center card border-info p-3"> 
                    <h1 class="text-info card-body"><?=_lang("no_{$content['safelink']}_posts")?></h1>
                </div>
            <?php endif;?>
                </div>
            </div>
        </section>
        <?php endif ?>
    <?php endif;?>
<div class="col-md-3 s-option">
    <?php 
        $url = 'ads/';
        if(isset($category_slug)){
            $url = 'ads/category/'.$category_slug;
        }
        if(isset($location_slug)){
            $url = 'ads/location/'.$location_slug;
        }
        if(isset($category_slug) && isset($location_slug)){
            $url = 'ads/location/'.$location_slug.'/category/'.$category_slug;
        }
    ?>
    
    <?php echo Form::open(['name' => 'filterAdsByAttributes', 'url' => $url, 'method' => 'GET', 'id'=> 'filterAdsByAttributes']); ?>

    
    <h5>Sort result by:</h5>
    <hr>

    <div class="form-group box-end">
        <select name="orderAds" class="form-control" id="exampleFormControlSelect1" onChange="this.form.submit();">
            <option value="date_desc" <?php if(!isset($orderAds) || $orderAds=='date_desc'){echo "selected";} ?>>Date: Newest on top</option>
            <option value="date_asc" <?php if(isset($orderAds) && $orderAds=='date_asc'){echo "selected";} ?>>Date: Oldest on top</option>
            <option value="price_desc" <?php if(isset($orderAds) && $orderAds=='price_desc'){echo "selected";} ?>>Price: High to Low</option>
            <option value="price_asc" <?php if(isset($orderAds) && $orderAds=='price_asc'){echo "selected";} ?>>Price: Low to High</option>
        </select>
    </div>

    <h5>Category :</h5>
    <hr>
    <p>
        <?php 
            $url = 'ads/';
            if(isset($location_slug)){$url = 'ads/location/'.$location_slug;} 
        ?>
            <a href="<?php echo e(url($url)); ?>">All Categories</a>
    </p>

    <ul class="category-list mb-4">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $url = 'ads/category/'.$category->slug;
                $ad_count = \App\Category::getCategoryAdsCount($category->id);
                if(isset($location_slug)){
                    $url = 'ads/location/'.$location_slug.'/category/'.$category->slug;
                    $ad_count = \App\Category::getCategoryAdsCount($category->id,$location_id);
                }
            ?>
            <?php if($ad_count > 0): ?>
            <li class="<?php echo (isset($category_slug))? ($category_slug == $category->slug)?'active':'hide':''; echo (isset($category_parent_slug))? ($category_parent_slug == $category->slug)?'active':'':'' ?>">
                <a href="<?php echo e(url($url)); ?>" class="<?php echo (isset($category_slug))? ($category_slug == $category->slug)?'active':'':''; echo (isset($category_parent_slug))? ($category_parent_slug == $category->slug)?'active':'':'' ?>">
                    <?php echo e($category->name); ?>

                    <?php //if(!isset($category_slug)){ ?>
                        <span class="add-count">(<?php echo $ad_count; ?>)</span>
                    <?php //} ?>
                </a>
                <ul class="sub-menu">
                <?php $subCategories = \App\Category::getSubCategoryByCategoryId($category->id);?>
                <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $url = 'ads/category/'.$sCat->slug;
                        $ad_count = \App\Category::getCategoryAdsCount($sCat->id);
                        if(isset($location_slug)){
                            $url = 'ads/location/'.$location_slug.'/category/'.$sCat->slug;
                        }
                        else{
                            $location_id = null;
                        }
                        if(!isset($ad_type_id)){
                            $ad_type_id = null;
                        }
                        if(!isset($min_price)){
                            $min_price = null;
                        }
                        else{ if($min_price === '0') {$min_price = null;} 
                        }
                        if(!isset($max_price)){
                            $max_price = null;
                        }
                        else{ if($max_price === '999999999999999999') {$max_price = null;} 
                        }
                        if(!isset($ad_cond)){
                            $ad_cond = null;
                        }
                        if(!isset($ad_brand_id)){
                            $ad_brand_id = null;
                        }                        
                        $url = $url. '?' .http_build_query(['orderAds' => 'date_desc', 'ad_type' => $ad_type_id,'price_min' => $min_price,'price_max' => $max_price, 'ad_condition' => $ad_cond, 'ad_brand' => $ad_brand_id]);
                        $ad_count = \App\Category::getCategoryAdsCount($sCat->id,$location_id,$ad_type_id,$min_price,$max_price,$ad_cond,$ad_brand_id);
                    ?>
                   
                    <li class="<?php echo (isset($category_slug))? ($category_slug == $sCat->slug)?'active':'':'';?>">
                        <a href="<?php echo e(url($url)); ?>" class="<?php echo (isset($category_slug))? ($category_slug == $sCat->slug)?'active':'':'';?>">
                            <?php echo e($sCat->name); ?>

                            <?php //if(!isset($category_parent_slug)){ ?>
                                <span class="add-count">
                                (<?php echo e($ad_count); ?>)
                                </span>
                            <?php //} ?>
                        </a>
                    </li>
                    
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <h5>Location :</h5>
    <hr>
    <p>
        <?php 
            $url = 'ads/';
            if(isset($category_slug)){$url = 'ads/category/'.$category_slug;} 
        ?>
            <a href="<?php echo e(url($url)); ?>">All Locations</a>
    </p>

    <ul class="location-list mb-4">
        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $url = 'ads/location/'.$location->slug;
                $ad_count = $ad_count = \App\Location::getLocationAdsCount($location->id);
                if(isset($category_slug)){
                    $url = 'ads/location/'.$location->slug.'/category/'.$category_slug;
                }else{ $category_id = null; }
                if(!isset($ad_type_id)){
                    $ad_type_id = null;
                }
                if(!isset($min_price)){
                    $min_price = null;
                }
                else{ if($min_price === '0') {$min_price = null;} 
                }
                if(!isset($max_price)){
                    $max_price = null;
                }
                else{ if($max_price === '999999999999999999') {$max_price = null;} 
                }
                if(!isset($ad_cond)){
                    $ad_cond = null;
                }
                if(!isset($ad_brand_id)){
                    $ad_brand_id = null;
                }
                //$min_price  = '1000';
                $url = $url. '?' .http_build_query(['orderAds' => 'date_desc', 'ad_type' => $ad_type_id,'price_min' => $min_price,'price_max' => $max_price,'ad_condition' => $ad_cond,'ad_brand' => $ad_brand_id]);
                $ad_count = $ad_count = \App\Location::getLocationAdsCount($location->id,$category_id,$ad_type_id,$min_price,$max_price,$ad_cond,$ad_brand_id);
            ?>
            <?php if($ad_count > 0): ?>
            <li class="<?php echo (isset($location_slug))? ($location_slug == $location->slug)?'active':'hide':''; echo (isset($location_parent_slug))? ($location_parent_slug == $location->slug) ? 'active':'':'' ?>">
                <a href="<?php echo e(url($url)); ?>" class="<?php echo (isset($location_slug))? ($location_slug == $location->slug)?'active':'':''; echo (isset($location_parent_slug))? ($location_parent_slug == $location->slug) ? 'active':'':'' ?>">
                    <?php echo e($location->name); ?>

                    <span class="add-count">
                        (<?php echo e($ad_count); ?>)
                    </span>
                </a>
                <ul class="sub-menu">
                    <?php $subLocation = \App\Location::getSubLocationByLocationId($location->id); ?>
                    <?php $__currentLoopData = $subLocation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subLoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $url = 'ads/location/'.$subLoc->slug;
                            $ad_count = $ad_count = \App\Location::getLocationAdsCount($subLoc->id);
                            if(isset($category_slug)){
                                $url = 'ads/location/'.$subLoc->slug.'/category/'.$category_slug;
                            }else{ $category_id = null;}
                            if(!isset($ad_type_id)){
                                $ad_type_id = null;
                            }
                            if(!isset($min_price)){
                                $min_price = null;
                            }
                             else{ if($min_price === '0') {$min_price = 'null';} 
                            }
                            if(!isset($max_price)){
                                $max_price = null;
                            }
                            else{ if($max_price === '999999999999999999') {$max_price = null;} 
                            }
                            if(!isset($ad_cond)){
                                $ad_cond = null;
                            }
                            if(!isset($ad_brand_id)){
                                $ad_brand_id = null;
                            }             

                            $url = $url. '?' .http_build_query(['orderAds' => 'date_desc', 'ad_type' => $ad_type_id,'price_min' => $min_price,'price_max' => $max_price,'ad_condition' => $ad_cond,'ad_brand' => $ad_brand_id]);
                            $ad_count = $ad_count = \App\Location::getLocationAdsCount($subLoc->id,$category_id,$ad_type_id,$min_price,$max_price,$ad_cond,$ad_brand_id);
                        ?>
                        <?php if($ad_count > 0): ?>
                        <li class="<?php echo (isset($location_slug))? ($location_slug == $subLoc->slug)?'active':'':'';?>">
                            <a href="<?php echo e(url($url)); ?>" class="<?php echo (isset($location_slug))? ($location_slug == $subLoc->slug)?'active':'':'';?>"><?php echo e($subLoc->name); ?></a>
                            <span class="add-count">
                                (<?php echo e($ad_count); ?>)
                            </span>
                        </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if(!isset($location_parent_slug)){ ?>
        <div id="loadMore">Load more</div>
        <?php } ?>
    </ul>

    <?php if(isset($category_parent_slug)): ?>
    
        <!--  Ad type -->
        <h5>Type of ad :</h5>
        <hr>
        <div class="col-lg-12 col-md-12">
        
            <?php $__currentLoopData = $ad_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    if(!isset($location_slug)){
                        $location_slug = null;
                    }
                    if(!isset($min_price)){
                        $min_price = null;
                    }
                    else{ if($min_price === '0') {$min_price = null;} 
                    }
                    if(!isset($max_price)){
                        $max_price = null;
                    }
                    else{ if($max_price === '999999999999999999') {$max_price = null;} 
                    }
                    if(!isset($ad_cond)){
                        $ad_cond = null;
                    }
                    if(!isset($ad_brand_id)){
                        $ad_brand_id = null;
                    }
                    $ad_count = \App\Adtype::getAdTypeAdsCount($ad_type->id, $category_slug, $location_slug,$min_price,$max_price,$ad_cond,$ad_brand_id);
                ?>
                <div class="form-group">
                    <?php if($ad_count > 0): ?>
                    <input onChange="this.form.submit();" class="radio" type="radio" name="ad_type" id="<?php echo e($ad_type->slug); ?>" value="<?php echo e($ad_type->id); ?>"
                    <?php echo (isset($ad_type_id))? ($ad_type_id == $ad_type->id)?'checked="checked"':'':''; ?> />
                    <?php if(($ad_type->slug) == 'to-rent' || ($ad_type->slug) == 'to-buy'){ echo 'Wanted -'; } ?>
                    <?php echo e($ad_type->name); ?> (<?php echo e($ad_count); ?>)
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <div class="col-lg-12 col-md-12">
            <div class="accordion" id="sidebar-accordion">
                <!-- Condition -->
                <?php if( count($ad_conditions) > 0 && isset($ad_cond)) { ?>
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" href="#conditionFilter">
                            Condition
                        </a>
                    </div>
                    <div id="conditionFilter" class="accordion-body collapse in">
                        <div class="accordion-inner">
                        <?php $__currentLoopData = $ad_conditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad_condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(!isset($location_slug)){
                                    $location_slug = null;
                                }
                                if(!isset($ad_type_id)){
                                    $ad_type_id = null;
                                }
                                if(!isset($min_price)){
                                    $min_price = null;
                                }
                                else{ if($min_price === '0') {$min_price = null;} 
                                }
                                if(!isset($max_price)){
                                    $max_price = null;
                                }
                                else{ if($max_price === '999999999999999999') {$max_price = null;} 
                                }
                                if(!isset($ad_brand_id)){
                                    $ad_brand_id = null;
                                }
            
                                $ad_count = \App\Ad::getConditionAdsCount($ad_condition->condition, $category_slug, $location_slug, $ad_type_id, $min_price,$max_price,$ad_brand_id);
                                //$ad_count = 10;
                            ?>
                            <div class="form-group">
                                <?php if(($ad_count > 0) && $ad_condition->condition != null): ?>
                                <input onChange="this.form.submit();" class="radio" type="radio" name="ad_condition" id="<?php echo e($ad_condition->condition); ?>" value="<?php echo e($ad_condition->condition); ?>"
                                <?php echo (isset($ad_cond))? ($ad_cond == $ad_condition->condition)?'checked="checked"':'':'';?> /> <?php echo e($ad_condition->condition); ?> (<?php echo e($ad_count); ?>)
                                <?php endif; ?>
                            </div>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <br/>
                <?php } ?>
                <?php if($ad_type_id != 5){ ?>
                    <!-- Price -->
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" href="#priceFilter">
                                Price (Rs)
                            </a>
                        </div>
                        <div id="priceFilter" class="accordion-body collapse">
                            <div class="accordion-inner">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <?php echo Form::text('price_min', '', ['id' => 'price_min', 'class' => 'form-control', 'placeholder' => 'min' ]); ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <?php echo Form::text('price_max', '', ['id' => 'price_max', 'class' => 'form-control', 'placeholder' => 'max' ]); ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <?php echo Form::submit( 'Apply filters', ['class' => 'btn btn-default', 'name' => 'filterPrice', 'value' => 'filterPrice']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <!-- Brand -->
                    <?php if(count($ad_brands) > 0) { ?>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" href="#brandFilter">
                            Brand
                        </a>
                        </div>
                        <div id="brandFilter" class="accordion-body collapse">
                            <div class="accordion-inner">
                                <?php $__currentLoopData = $ad_brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad_brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        if(!isset($location_slug)){
                                            $location_slug = null;
                                        }
                                        if(!isset($ad_type_id)){
                                            $ad_type_id = null;
                                        }
                                        if(!isset($min_price)){
                                            $min_price = null;
                                        }
                                        else{ if($min_price === '0') {$min_price = null;} 
                                        }
                                        if(!isset($max_price)){
                                            $max_price = null;
                                        }
                                        else{ if($max_price === '999999999999999999') {$max_price = null;} 
                                        }
                                        if(!isset($ad_cond)){
                                            $ad_cond = null;
                                        }
                                        //$ad_count = 10;
                                        $ad_count = \App\Brand::getBrandAdsCount($ad_brand->id,$category_slug,$location_slug,$ad_type_id,$min_price,$max_price,$ad_cond);
                                    ?>
                                    <div class="form-group">
                                        <?php if($ad_count > 0): ?>
                                        <input onChange="this.form.submit();" class="radio" type="radio" name="ad_brand" id="<?php echo e($ad_brand->slug); ?>" value="<?php echo e($ad_brand->id); ?>"
                                        <?php echo (isset($ad_brand_id))? ($ad_brand_id == $ad_brand->id)?'checked="checked"':'':'';?> /> <?php echo e($ad_brand->name); ?> (<?php echo e($ad_count); ?>)
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <?php }?>
                <?php } ?>

            </div>
        </div>

    <?php endif; ?>  

    
    <?php echo Form::close(); ?>


</div>
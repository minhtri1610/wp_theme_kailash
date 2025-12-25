<?php
/**
 * Template Name: Single people
 *
 * Template này xử lý hiển thị trang chi tiết cho Experience.
 * Logic:
 * - Nếu là Level 2 (Con): Hiển thị nội dung + Kiến thức liên quan (Knowledge).
 * - Nếu là Level 1 (Cha): Hiển thị danh sách con + Cộng sự liên quan (People).
 *
 * @package kailash
 */

get_header();

// Lấy ID hiện tại
$current_id = get_the_ID();

// Lấy các field ACF
$full_name = get_field('ho_ten');
$position = get_field('position');
$linh_vuc_phu_trach = get_field('linh_vuc_phu_trach');
$vi_tri_co_van = get_field('vi_tri_co_van');
$mo_ta_linh_vuc_tu_van = get_field('mo_ta_linh_vuc_tu_van');
$anh_bia = get_field('anh_bia');
$ngon_ngu = get_field('ngon_ngu');
$phone    = get_field('phone');
$email    = get_field('email');
$linkedin = get_field('link_linkedin');
$facebook = get_field('link_facebook');
$dia_diem_lam_viec = get_field('dia_diem_lam_viec');
$mo_ta_ngan = get_field('mo_ta_ngan');
$hoc_van = get_field('hoc_van');
$cong_viec_hien_tai = get_field('cong_viec_hien_tai');
$company_worked = get_field('company_worked');
$kinh_nghiem = get_field('kinh_nghiem');
$cong_trinh_nckh = get_field('cong_trinh_nckh');
// Lấy danh sách Lĩnh vực phụ trách (Relationship field)
$related_experiences = get_field('assigned_experience_parent');
?>

<div class="wrapper-single-experience">
    <div class="container mx-auto px-4">
        <!-- BREADCRUMB (Điều hướng tổng quát) -->
        <?php 
        if (function_exists('kailash_breadcrumbs')) {
            kailash_breadcrumbs();
        } else {
            // Fallback nếu chưa include file breadcrumbs
            ?>
            <div class="breadcrumb text-sm text-gray-500">
                <a href="<?php echo home_url(); ?>">Home</a> / 
                <span class="text-gray-900"><?php the_title(); ?></span>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="head-banner mb-3 relative">
        <?php if ($anh_bia != '') : ?>
            <div class="w-full max-h-[48vw]">
                <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-lg">
                    <img class="w-full h-[48vw] object-cover hover:scale-105 transition-transform duration-500" src="<?php echo $anh_bia; ?>" />
                </a>
            </div>
        <?php else : ?>
            <img class="w-full h-[48vw] object-cover hover:scale-105 transition-transform duration-500" src="https://dummyimage.com/380x240/737373/fff&text=1250x300px" />
        <?php endif; ?>

        <div class="info-block absolute inset-0 m-auto container flex items-center">
            <div class="wapper-info inline-block w-auto min-w-[30vw] max-w-[60vw]">
                <div class="name-tag ">
                    <h1 class="text-5xl font-weight-bold mb-3"><?php echo $full_name; ?></h1>
                    <p class="mb-3 text-xl"><span class=" text-[#737373]"><?php echo implode(', ', $position); ?> | <?php echo implode(', ', $dia_diem_lam_viec); ?></span></p>
                </div>
                <hr class="border-[#737373] mt-3">
                <div class="m-social mt-3 flex">
                    <div class="m-phone mr-2">
                        <?php if ($phone != "") : ?>
                            <span><a href="tel:+84901234567" class="underline underline-offset-1"><i class="fa-solid fa-phone  p-3 rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white"></i></a></span>
                        <?php endif; ?>
                    </div>
                    <a target="_blank" class="mr-2" href="<?php echo $facebook; ?>"><i class="fa-brands fa-facebook p-3 rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white"></i></a>
                    <a target="_blank" class="mr-2" href="<?php echo $linkedin; ?>"><i class="fa-brands fa-linkedin p-3 rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white"></i></a>
                    <a target="_blank" class="mr-2" href="mailto:<?php echo $email; ?>"><i class="fa-solid fa-envelope p-3 rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white"></i></a>
                </div>

                <a href="" class="p-2 rounded-full bg-[#3e3e3e80] block text-center text-white mt-[3rem] w-[135px]">
                    <i class="fa-solid fa-envelope"></i> Contact <i class="fa-solid fa-angle-right"></i>
                </a>

                <div class="icon-action my-3 flex">
                    <a href="" class="px-5 py-3 text-xl rounded bg-white text-[#3e3e3e] mr-3"><i class="fa-solid fa-print"></i></a>
                    <a href="" class="px-5 py-3 text-xl rounded bg-white text-[#3e3e3e]"><i class="fa-solid fa-share"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto py-4 relative mb-[5rem]">
        <div class="content-desc absolute w-full bg-white p-10 h-30vh z-[3] -top-[10vh] shadow-[1px_3px_3px_1px] shadow-[#dcdcdc]">
                            
            <?php 
                if($mo_ta_ngan != '') {
                    echo nl2br($mo_ta_ngan); 
                } else{
                    echo ("Chưa có thông tin ...");
                }
            ?>
        </div>

        <div class="grid grid-cols-3 gap-4 pt-[12%]">
            <div class="col-span-2">
                <div class="desc-info my-4">
                    <h3 class="text-xl text-[#aa7d59] border-b border-b-[#dcdcdc] mb-[15px] pb-2.5"><i class="fa-solid fa-briefcase  text-[#aa7d59]"></i> Tổ chức chuyên môn nghề nghiệp đang tham gia</h3>
                    <?php echo nl2br($cong_viec_hien_tai); ?>
                </div>
                <div class="desc-info  my-4">
                    <h3 class="text-xl text-[#aa7d59] border-b border-b-[#dcdcdc] mb-[15px] pb-2.5"><i class="fa-solid fa-graduation-cap text-[#aa7d59]"></i> Học vấn</h3>
                    <?php echo nl2br($hoc_van); ?>
                </div>
                <div class="desc-info my-4">
                    <h3 class="text-xl text-[#aa7d59] border-b border-b-[#dcdcdc] mb-[15px] pb-2.5"><i class="fa-solid fa-building-circle-check text-[#aa7d59]"></i> Tổ chức đã từng làm việc – Chức vụ từng đảm nhiệm</h3>
                    <?php echo nl2br($company_worked); ?>
                </div>
                <div class="desc-info my-4">
                    <h3 class="text-xl text-[#aa7d59] border-b border-b-[#dcdcdc] mb-[15px] pb-2.5"> <i class="fa-solid fa-clipboard-check text-[#aa7d59]"></i> Dự án đã từng tham gia</h3>
                    <?php echo nl2br($kinh_nghiem); ?>
                </div>
                <div class="desc-info my-4">
                    <h3 class="text-xl text-[#aa7d59] border-b border-b-[#dcdcdc] mb-[15px] pb-2.5"> <i class="fa-regular fa-newspaper text-[#aa7d59]"></i> Bài viết/công trình nghiên cứu khoa học</h3>
                    <?php echo nl2br($cong_trinh_nckh); ?>
                </div>
            </div>

            <div class="left-content border-l border-gray-300 pl-3">
                <div class="desc-info my-4">
                    <h3 class="text-xl text-[#aa7d59] border-b border-b-[#dcdcdc] mb-[15px] pb-2.5"><i class="fa-solid fa-book-bookmark text-[#aa7d59]"></i> Kinh nghiệm</h3>
                    <?php foreach( $linh_vuc_phu_trach as $exp ): ?>
                        <!-- Lấy tiêu đề -->
                        <a href="<?php echo get_permalink( $exp ); ?>"><h4 class="text-lg hover:text-[#00a174]"> - <?php echo get_the_title( $exp ); ?></h4></a>
                        
                    <?php endforeach; ?>
                </div>
                <div class="box-contact">
                    <a href="" class="p-2 rounded bg-[#016549] block text-center text-white mt-[3rem] w-[150px]"><i class="fa-solid fa-envelope"></i> Contact <i class="fa-solid fa-angle-right"></i></a>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

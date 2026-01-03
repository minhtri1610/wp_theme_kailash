<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kailash
 */

$settings_page = get_page_by_path('theme-settings');
$option_id = $settings_page ? $settings_page->ID : false;
if (!$option_id) $option_id = get_option('page_on_front'); // Fallback

// Lấy ngôn ngữ hiện tại
$lang = function_exists('pll_current_language') ? pll_current_language() : 'vi';

$company_name = get_field('company_name', $option_id);

$social_facebook = get_field('social_facebook', $option_id);
$social_linkedin = get_field('link_linkedin', $option_id);
?>
	<footer id="site-footer" class="bg-gradient-to-b from-[#016549] to-[#003425] pt-10 relative">
		<div class="wapper-footer container">
			<div class="list-menu border-b border-b-[#C4C4C4]/20">
				<?php
					wp_nav_menu(array(
						'menu_id'        => 'footer-menu',
						'theme_location' => 'footer_menu',
						'container'      => false,
						'menu_class'     => 'top-menu flex flex-row content-center justify-start space-x-4',
						'fallback_cb'    => false,
					));
				?>
			</div>
			<div class="list-social-media mt-3">
				<ul class="flex flex-row">
					<?php if($social_facebook): ?>
                    <li class="mr-4">
                        <a href="<?php echo esc_url($social_facebook); ?>" target="_blank" class="block hover:-translate-y-1 transition-transform">
                            <i class="fa-brands fa-facebook text-[#dfdfdf] hover:text-white text-3xl"></i>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if($social_linkedin): ?>
                    <li>
                        <a href="<?php echo esc_url($social_linkedin); ?>" target="_blank" class="block hover:-translate-y-1 transition-transform">
                            <i class="fa-brands fa-linkedin text-[#dfdfdf] hover:text-white text-3xl"></i>
                        </a>
                    </li>
                    <?php endif; ?>
				</ul>
			</div>

			<div class="footer-info my-10">

				<div class="grid grid-cols-5 gap-4 mb-5">
					<div class="">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/chinh-sach-trang-web'); ?>"><?php pll_e('Chính sách trang web'); ?></a>
					</div>
					<div class="col-span-2">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/chinh-sach-co-ban-ve-bao-mat-thong-tin'); ?>"><?php pll_e('Chính sách cơ bản về bảo mật thông tin'); ?></a>
					</div>
				</div>

				<div class="grid grid-cols-5 gap-4 mb-5">
					<div class="">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/tuyen-bo-mien-tru-trach-nhiem'); ?>"><?php pll_e('Tuyên bố miễn trừ trách nhiệm'); ?></a>
					</div>
					<div class="col-span-2">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/chinh-sach-bao-mat-danh-cho-chu-the-du-lieu'); ?>"><?php pll_e('Chính sách bảo mật dữ liệu dành cho chủ thể dữ liệu'); ?></a>
					</div>
				</div>

				<div class="grid grid-cols-5 gap-4 mb-5">
					<div class="">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/chinh-sach-cookie'); ?>"><?php pll_e('Chính sách cookie'); ?></a>
					</div>
					<div class="col-span-2">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/thong-tin-thue-va-xuat-hoa-don-cua-kailash'); ?>"><?php pll_e('Thông tin Thuế và Xuất Hóa đơn của Kailash'); ?></a>
					</div>
				</div>

				<div class="grid grid-cols-5 gap-4 mb-5">
					<div class="">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/thong-tin-phap-ly'); ?>"><?php pll_e('Thông tin pháp lý'); ?></a>
					</div>
					<div class="col-span-2">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/quan-diem-cua-kailash-ve-xung-dot-loi-ich'); ?>"><?php pll_e('Cách tiếp cận của công ty đối với xung đột lợi ích'); ?></a>
					</div>
				</div>

				<div class="grid grid-cols-5 gap-4 mb-5">
					<div class="">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/chinh-sach-ai-doanh-nghiep'); ?>"><?php pll_e('Chính sách AI của doanh nghiệp'); ?></a>
					</div>
					<div class="col-span-2">
						<a class="text-white text-sm hover:text-slate-300" href="<?php echo site_url('/chinh-sach-bao-ve-thong-tin-ca-nhan'); ?>"><?php pll_e('Chính sách bảo vệ thông tin cá nhân'); ?></a>
					</div>
				</div>

			</div>
			<div class="copyright text-center pb-3">
				<p class="text-[#dfdfdf] text-sm">© 2025 <?php echo $company_name ? esc_html($company_name) : 'Kailash'; ?>. All rights reserved.</p>
			</div>
		</div>
		<div class="footer-arrows">

		</div>

		<a id="backToTop" href="#" class="fixed right-10 z-50 hidden p-3 transition-opacity duration-300"
    style="bottom: 20px;">Page Top</a>
	</footer>

	
</div><!-- #page -->

<?php wp_footer(); ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.banner-header').slick({
			fade: true,
			dotsClass: 'slick-dots',
			arrows: false,
			autoplay: true,
			autoplaySpeed: 3000,
        });

		$('#slides-top-people').slick({
			fade: true,
			dotsClass: 'slick-dots',
			arrows: false,
			autoplay: true,
			autoplaySpeed: 1000,
        });

		$('#list-people').slick({
			infinite: true,
			slidesToShow: 4,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 1000,
		});

		$('#slides-recent-work').slick({
			slidesToShow: 3,
			slidesToScroll: 3,
			arrows: true,
			autoplay: true,
			autoplaySpeed: 1000,
        });
		
		
    });
	(function() {
		const animateNumber = (element, target, duration) => {
			let startTime;
			const initialNumber = 0;

			const easingFunction = t => 1 - Math.pow(1 - t, 4);

			const animate = time => {
			if (!startTime) startTime = time;
			const elapsedTime = time - startTime;
			const t = Math.min(elapsedTime / duration, 1);
			const newValue = initialNumber + (target - initialNumber) * easingFunction(t);

			element.textContent = Math.round(newValue);

			if (elapsedTime < duration) {
				requestAnimationFrame(animate);
			} else {
				element.textContent = target;
			}
			};

			requestAnimationFrame(animate);
		};

		const onIntersection = entries => {
			entries.forEach(entry => {
			if (entry.isIntersecting) {
				const el = entry.target;
				const finalNumber = parseInt(el.textContent, 10);
				const animDuration = parseInt(el.getAttribute('duration'), 10) || 2000;

				animateNumber(el, finalNumber, animDuration);
				observer.unobserve(el);
			}
			});
		};

		const observer = new IntersectionObserver(onIntersection);
		
		document.addEventListener("DOMContentLoaded", () => {
			document.querySelectorAll('[counter-element="number"]').forEach(el => {
			observer.observe(el);
			});
		});

		document.addEventListener("DOMContentLoaded", function() {
    
			// 1. Lấy tất cả các tab link và tab content
			const tabLinks = document.querySelectorAll(".tab-link");
			const tabContents = document.querySelectorAll(".tab-content");

			// Các class cho trạng thái Active (Đang chọn)
			const activeClasses = ["text-[#125f4b]", "border-b-2", "border-[#125f4b]"];
			
			// Các class cho trạng thái Inactive (Không chọn)
			const inactiveClasses = ["text-gray-500", "border-transparent", "hover:text-[#125f4b]", "hover:border-gray-300"];

			tabLinks.forEach(link => {
				link.addEventListener("click", (e) => {
					e.preventDefault(); // Ngăn chặn nhảy trang

					// A. XỬ LÝ STYLE CHO TAB LINK
					// Reset tất cả các tab về trạng thái inactive
					tabLinks.forEach(tab => {
						tab.classList.remove(...activeClasses);
						tab.classList.add(...inactiveClasses);
					});

					// Set tab được click thành active
					link.classList.remove(...inactiveClasses);
					link.classList.add(...activeClasses);

					// B. XỬ LÝ HIỂN THỊ CONTENT
					// Ẩn tất cả nội dung
					tabContents.forEach(content => {
						content.classList.add("hidden");
					});

					// Hiện nội dung tương ứng (Dựa vào data-target)
					const targetId = link.getAttribute("data-target");
					const targetContent = document.querySelector(targetId);
					if (targetContent) {
						targetContent.classList.remove("hidden");
					}
				});
			});
		});
	})();
</script>
<script>
	document.addEventListener('DOMContentLoaded', () => {
		const backToTopBtn = document.getElementById('backToTop');
		const footer = document.getElementById('site-footer');
		
		// Cấu hình khoảng cách
		const defaultBottom = 20; // Cách đáy màn hình 20px khi ở trạng thái bình thường
		const offsetFromFooter = 20; // Cách mép trên của footer 20px khi chạm footer

		// Hàm cập nhật vị trí nút
		const updateButtonPosition = () => {
			// 1. Logic Ẩn/Hiện
			if (window.scrollY > 300) {
				backToTopBtn.classList.remove('hidden');
				// Thêm chút delay nhỏ để transition opacity hoạt động nếu muốn
			} else {
				backToTopBtn.classList.add('hidden');
			}

			// 2. Logic Tránh Footer (Quan trọng)
			if (footer) {
				// Lấy vị trí của footer so với viewport hiện tại
				const footerRect = footer.getBoundingClientRect();
				const windowHeight = window.innerHeight;

				// Nếu đỉnh của footer nằm trong vùng nhìn thấy (viewport)
				if (footerRect.top < windowHeight) {
					// Tính toán khoảng cách nút bị đẩy lên
					// Công thức: (Chiều cao màn hình - Vị trí đỉnh footer) + Khoảng cách mong muốn
					const newBottom = (windowHeight - footerRect.top) + offsetFromFooter;
					backToTopBtn.style.bottom = `${newBottom}px`;
				} else {
					// Nếu chưa thấy footer, reset về vị trí mặc định
					backToTopBtn.style.bottom = `${defaultBottom}px`;
				}
			}
		};

		// Hàm cuộn mượt (Custom Animation) - Đảm bảo mượt trên mọi trình duyệt
		const smoothScrollToTop = () => {
			const startPosition = window.scrollY;
			const targetPosition = 0;
			const distance = targetPosition - startPosition;
			const duration = 500; // Tốc độ cuộn (ms)
			let startTime = null;

			function animation(currentTime) {
				if (startTime === null) startTime = currentTime;
				const timeElapsed = currentTime - startTime;
				const run = easeOutCubic(timeElapsed, startPosition, distance, duration);
				window.scrollTo(0, run);
				if (timeElapsed < duration) requestAnimationFrame(animation);
			}

			function easeOutCubic(t, b, c, d) {
				t /= d;
				t--;
				return c * (t * t * t + 1) + b;
			}

			requestAnimationFrame(animation);
		};

		// Gắn sự kiện
		window.addEventListener('scroll', updateButtonPosition);
		window.addEventListener('resize', updateButtonPosition); // Cập nhật khi xoay màn hình/resize
		backToTopBtn.addEventListener('click', smoothScrollToTop);
	});
</script>
</body>
</html>

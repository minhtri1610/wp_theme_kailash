/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./**/*.php",
    "./assets/js/*.js"
  ],
  theme: {
    container: {
      screens: {
        sm: '640px',
        md: '768px',
        lg: '1024px',
        xl: '1208px', // Đặt giá trị tùy chỉnh của bạn ở đây
      },
      center: true,
      padding: '0.75rem',
    },
    extend: {
      screens: {
        'xs': '475px',
      },
      fontFamily: {
        // Đặt tên class là font-gilda
        'gilda': ['"Gilda Display"', 'serif'], 
        
        // Đặt tên class là font-nunito
        'nunito': ['"Nunito Sans"', 'sans-serif'], 
      },
    },
  },
  plugins: [],
}


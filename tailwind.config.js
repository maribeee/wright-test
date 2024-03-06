/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      backgroundColor: {
        primary: '#ffffff',
        error: '#fef1f1',
        success: '#f1f8f1',
        button: {
          primary: '#ffae00',
          hover: '#f1f8f1',
          disabled: '#bababa',
        },
      },
      borderColor: {
        error: '#dc9c9c',
      },
      textColor: {
        primary: '#000000',
        secondary: '#ffae00',
        error: '#d0021b',
        warning: '#b08217',
        button: {
          primary: '#ffffff',
          hover: '#bc7f00',
          disabled: '#3e3e3e',
        },
      },
    },
  },
  plugins: [],
}


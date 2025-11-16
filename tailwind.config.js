import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                // lora: ["Lora", ...defaultTheme.fontFamily.serif],
                playfair: ["Playfair Display", ...defaultTheme.fontFamily.serif],
            },
            clipPath: {
                'trapezoid': 'polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%)',
            },
        },
        colors: {
            transparent: "transparent",
            current: "currentColor",
            black: "#000000",
            white: "#ffffff",
            ivorywhite: "#FFF8F9",
            gray:"#9CA3AF",
            Charcoal:"#333333",


            // Bạn phải tự định nghĩa lại các màu cần thiết khác
            primary: {
                250: "#FFF0F3",
                225: "#EC5353",
                200: "#FFA6A6",
                175: "#EBA3A3",
                150: "#F8B6C6",
                125: "#FDECEF",
                100: "#FFF0F5",
                50: "#FFF0F3",
                25: "#FFF6F7",
                0: "#FFF8F9"
            },

            
        },
    },
    plugins: [forms,
        require('@tailwindcss/typography'),
        require('tailwind-clip-path'),
    ],
};

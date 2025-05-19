<!DOCTYPE html>
<html lang="en" class="default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm email | {{get_settings('system_title')}}</title>
</head>

<body >
    <main style="background: #fafafa;">
        <div style="max-width: 640px; width: 100%; margin: 0 auto; background: #ffffff;">
            <div style="padding: 40px 48px;">
                <div style="margin-bottom: 30px;">
                    <img src="{{get_image(get_settings('logo'))}}" alt="">
                </div>
                <div style="margin: 30px 0; border-top: 1px solid #dbdfeb;">
                    <h1 style="margin: 30px 0 24px 0; font-weight: 600; font-size: 24px; line-height: 24px; color: #212534;">Confirm your email address</h1>
                    <div style="font-weight: 400; font-size: 16px; line-height: 24px; color: #6d718c;">
                        <p>Hi [client_name],</p>
                        <p style="margin-bottom: 24px;">We are glad to have you onboard! You are already on your way to creating beautiful visual products.</p>
                        <p style="margin: 0;">Whether you are here for your brand, for a cause, or just for fun welcome! If there is anything you need, we will be here every step of the way.</p>
                    </div>
                    <a href="[forget_password_link]" style="display: inline-block; background: #1b84ff; text-decoration: none; font-weight: 600; border-radius: 6px; color: #ffffff; font-size: 14px; padding: 19px 45px; margin-top: 24px;">Confirm Email Address</a>
                </div>
                <div style="font-weight: 500; font-size: 16px; line-height: 24px; color: #212534; ">
                    <p style="margin-bottom: 24px;">This email was sent to <a href="mainto:[site_email]" style="color: #1b84ff;">[site_email]</a>. If you did rather not receive this kind of email. Do not want any more emails from Notable?<a href="#" style="color: #1b84ff;">Unsubscribe</a>.
                    </p>
                    <p style="margin: 0;">
                        [address]
                    </p>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span>[footer_text]</span>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <a href="#">
                                <span>
                                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1429_7943)">
                                            <path
                                                d="M18.902 8.99994C18.902 4.02941 14.6706 0 9.45099 0C4.23135 0 0 4.02941 0 8.99994C0 13.492 3.45607 17.2154 7.97427 17.8905V11.6015H5.57461V8.99994H7.97427V7.01714C7.97427 4.76153 9.38528 3.5156 11.5441 3.5156C12.5778 3.5156 13.6596 3.69138 13.6596 3.69138V5.90621H12.4679C11.2939 5.90621 10.9277 6.60001 10.9277 7.31245V8.99994H13.5489L13.1299 11.6015H10.9277V17.8905C15.4459 17.2154 18.902 13.492 18.902 8.99994Z"
                                                fill="#99A1B7" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1429_7943">
                                                <rect width="18.902" height="17.9999" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                            </a>
                            <a href="#" style="display: flex; align-items: center; gap: 16px;">
                                <span>
                                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1429_7963)">
                                            <path
                                                d="M12.1865 7.62924L19.1179 0.0491333H17.4754L11.4568 6.63083L6.6498 0.0491333H1.10547L8.37463 10.0018L1.10547 17.9507H2.7481L9.10387 11.0002L14.1804 17.9507H19.7248L12.1861 7.62924H12.1865ZM9.93668 10.0895L9.20017 9.09845L3.33996 1.21244H5.86293L10.5922 7.5767L11.3287 8.56776L17.4762 16.8403H14.9532L9.93668 10.0899V10.0895Z"
                                                fill="#99A1B7" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1429_7963">
                                                <rect width="19.0285" height="17.9016" fill="white" transform="translate(0.902344 0.0491333)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                            </a>
                            <a href="#">
                                <span>
                                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1429_7965)">
                                            <path
                                                d="M9.96977 1.62069C12.3852 1.62069 12.6712 1.63124 13.6211 1.67343C14.5039 1.7121 14.9807 1.85975 15.2985 1.9828C15.7187 2.14452 16.0224 2.34139 16.3367 2.65428C16.6545 2.97068 16.8487 3.26951 17.0111 3.68787C17.1347 4.00427 17.283 4.48239 17.3219 5.35778C17.3643 6.30699 17.3749 6.59175 17.3749 8.99291C17.3749 11.3976 17.3643 11.6823 17.3219 12.628C17.283 13.5069 17.1347 13.9815 17.0111 14.298C16.8487 14.7163 16.6509 15.0186 16.3367 15.3315C16.0188 15.6479 15.7187 15.8413 15.2985 16.003C14.9807 16.1261 14.5004 16.2737 13.6211 16.3124C12.6677 16.3546 12.3816 16.3651 9.96977 16.3651C7.55437 16.3651 7.26834 16.3546 6.31842 16.3124C5.4356 16.2737 4.95888 16.1261 4.64106 16.003C4.22084 15.8413 3.91715 15.6444 3.60287 15.3315C3.28505 15.0151 3.09083 14.7163 2.92839 14.298C2.8048 13.9815 2.65648 13.5034 2.61764 12.628C2.57526 11.6788 2.56467 11.3941 2.56467 8.99291C2.56467 6.58824 2.57526 6.30347 2.61764 5.35778C2.65648 4.47888 2.8048 4.00427 2.92839 3.68787C3.09083 3.26951 3.28858 2.96717 3.60287 2.65428C3.92068 2.33787 4.22084 2.14452 4.64106 1.9828C4.95888 1.85975 5.43913 1.7121 6.31842 1.67343C7.26834 1.63124 7.55437 1.62069 9.96977 1.62069ZM9.96977 0C7.51553 0 7.2083 0.0105468 6.24427 0.052734C5.28376 0.0949212 4.62341 0.249608 4.05134 0.471091C3.45455 0.70312 2.94958 1.00898 2.44814 1.51171C1.94317 2.01092 1.63594 2.51366 1.40288 3.10428C1.18041 3.67732 1.02503 4.33122 0.982657 5.28746C0.940281 6.25074 0.929688 6.5566 0.929688 8.99994C0.929688 11.4433 0.940281 11.7491 0.982657 12.7089C1.02503 13.6651 1.18041 14.3226 1.40288 14.8921C1.63594 15.4862 1.94317 15.989 2.44814 16.4882C2.94958 16.9874 3.45455 17.2968 4.04781 17.5253C4.62341 17.7468 5.28023 17.9014 6.24073 17.9436C7.20477 17.9858 7.51199 17.9964 9.96623 17.9964C12.4205 17.9964 12.7277 17.9858 13.6917 17.9436C14.6522 17.9014 15.3126 17.7468 15.8847 17.5253C16.4779 17.2968 16.9829 16.9874 17.4843 16.4882C17.9858 15.989 18.2965 15.4862 18.5261 14.8956C18.7485 14.3226 18.9039 13.6687 18.9463 12.7124C18.9887 11.7527 18.9993 11.4468 18.9993 9.00346C18.9993 6.56011 18.9887 6.25425 18.9463 5.2945C18.9039 4.33825 18.7485 3.68083 18.5261 3.11131C18.3036 2.51365 17.9964 2.01092 17.4914 1.51171C16.99 1.01249 16.485 0.70312 15.8917 0.474606C15.3161 0.253123 14.6593 0.0984368 13.6988 0.0562496C12.7312 0.0105468 12.424 0 9.96977 0Z"
                                                fill="#99A1B7" />
                                            <path
                                                d="M9.97176 4.37683C7.40805 4.37683 5.32812 6.44752 5.32812 8.99985C5.32812 11.5522 7.40805 13.6229 9.97176 13.6229C12.5355 13.6229 14.6154 11.5522 14.6154 8.99985C14.6154 6.44752 12.5355 4.37683 9.97176 4.37683ZM9.97176 11.9987C8.30853 11.9987 6.95958 10.6557 6.95958 8.99985C6.95958 7.344 8.30853 6.00104 9.97176 6.00104C11.635 6.00104 12.9839 7.344 12.9839 8.99985C12.9839 10.6557 11.635 11.9987 9.97176 11.9987Z"
                                                fill="#99A1B7" />
                                            <path d="M15.883 4.19401C15.883 4.79166 15.3957 5.2733 14.7989 5.2733C14.1986 5.2733 13.7148 4.78814 13.7148 4.19401C13.7148 3.59635 14.2022 3.11472 14.7989 3.11472C15.3957 3.11472 15.883 3.59987 15.883 4.19401Z" fill="#99A1B7" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1429_7965">
                                                <rect width="18.0802" height="17.9999" fill="white" transform="translate(0.929688)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>

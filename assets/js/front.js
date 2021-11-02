/* global nssFront:object, Kakao:object */
(function () {
    const opts = nssFront.opts || {
        width: 640,
        height: 320,
        kakaoApiKey: '',
        shareParams: {
            title: '',
            thumbnail: '',
            permalink: '',
        }
    };

    const sharer = {
        share(type) {
            if ('function' === typeof this[type]) {
                this[type].call(this, opts.shareParams);
            }
        },
        facebook(s) {
            this.openPopup('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(s.permalink));
        },
        twitter(s) {
            this.openPopup('https://twitter.com/share?url=' + encodeURIComponent(s.permalink) + '&text=' + encodeURIComponent(s.title));
        },
        linkedIn(s) {
            this.openPopup('https://www.linkedin.com/shareArticle?url=' + encodeURIComponent(s.permalink) + '&title=' + encodeURIComponent(s.title));
        },
        telegram(s) {
            this.openPopup('https://t.me/share/url?url=' + encodeURIComponent(s.permalink) + '&text=' + encodeURIComponent(s.title))
        },
        kakaoTalk(s) {
            if (isKakaoAvailable()) {
                if (!Kakao.isInitialized()) {
                    Kakao.init(opts.kakaoApiKey);
                }
                Kakao.Link.sendDefault({
                    objectType: 'feed',
                    content: {
                        title: s.title,
                        imageUrl: s.thumbnail,
                        link: {
                            webUrl: s.permalink,
                            mobileWebUrl: s.permalink
                        }
                    }
                });
            }
        },
        naverBlog(s) {
            this.openPopup('https://blog.naver.com/LinkShare.nhn?url=' + encodeURIComponent(s.permalink) + '&title=' + encodeURIComponent(s.title));
        },
        openPopup(href) {
            const top = (screen.availHeight - opts.height) * 0.5,
                left = (screen.availWidth - opts.width) * 0.5,
                params = 'width=' + opts.width + ',height=' + opts.height + ',left=' + left + ',top=' + top;

            window.open(href, 'nss', params);
        },
    };

    function isKakaoAvailable() {
        return window.hasOwnProperty('Kakao') && 'object' === typeof window.Kakao;
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (opts.kakaoApiKey.length > 0) {
            let script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://developers.kakao.com/sdk/js/kakao.min.js'
            script.onload = function () {
                if (isKakaoAvailable()) {
                    Kakao.init(opts.kakaoApiKey);
                }
            };
            document.getElementsByTagName('head')[0].appendChild(script);
        }

        document.querySelectorAll('[data-nss]').forEach(function (elem) {
            elem.addEventListener('click', (e) => {
                const target = e.target,
                    type = target.dataset.nss;
                if (target.tagName === 'A' && target.classList.contains('share')) {
                    e.preventDefault();
                }
                sharer.share(type);
            }, true);
        });
    });


    window.naranSocialShare = sharer;
})();

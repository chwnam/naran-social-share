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
        },
        textCopiedToClipboard: ''
    };

    const sharer = {
        share(type) {
            if ('function' === typeof this[type]) {
                this[type].call(this, opts.shareParams);
                document.dispatchEvent(new CustomEvent('nss', {detail: {type: type, params: opts.shareParams}}));
            }
        },
        openPopup(href) {
            const top = (screen.availHeight - opts.height) * 0.5,
                left = (screen.availWidth - opts.width) * 0.5,
                params = 'width=' + opts.width + ',height=' + opts.height + ',left=' + left + ',top=' + top;
            window.open(href, 'nss', params);
        },
        loadScript(href, callback) {
            let script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = href
            if (callback) {
                script.onload = callback;
            }
            document.getElementsByTagName('head')[0].appendChild(script);
        },
        clipboard(s) {
            if (!navigator.clipboard) {
                this.clipboardFallback(s);
                return;
            }

            navigator.clipboard.writeText(s.permalink).then(function() {
                alert(opts.textCopiedToClipboard);
            }, function(err) {
                console.error('Clipboard API Failed: ', err);
            });
        },
        clipboardFallback(s) {
            if (s.permalink && s.permalink.length) {
                let input = document.createElement('input');
                input.type = 'text';
                input.value = s.permalink;
                document.body.appendChild(input);
                input.select();
                input.setSelectionRange(0, s.permalink.length);
                document.execCommand('copy');
                input.remove();
                alert(opts.textCopiedToClipboard);
            }
        },
        facebook(s) {
            this.openPopup('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(s.permalink));
        },
        kakaoStory(s) {
            if (this.isKakaoAvailable()) {
                if (!Kakao.isInitialized()) {
                    Kakao.init(opts.kakaoApiKey);
                }
                Kakao.Story.share({
                    url: s.permalink,
                    text: s.title
                });
            }
        },
        kakaoTalk(s) {
            if (this.isKakaoAvailable()) {
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
        line(s) {
            this.openPopup('https://social-plugins.line.me/lineit/share?url=' + encodeURIComponent(s.permalink));
        },
        linkedIn(s) {
            this.openPopup('https://www.linkedin.com/shareArticle?url=' + encodeURIComponent(s.permalink) + '&title=' + encodeURIComponent(s.title));
        },
        naverBlog(s) {
            this.openPopup('https://blog.naver.com/LinkShare.nhn?url=' + encodeURIComponent(s.permalink) + '&title=' + encodeURIComponent(s.title));
        },
        pinterest(s) {
            if (window.hasOwnProperty('PinUtils') && 'object' === typeof window.PinUtils) {
                window.PinUtils.pinAny();
            }
        },
        pocket(s) {
            this.openPopup('https://widgets.getpocket.com/v1/popup?url=' + encodeURIComponent(s.permalink));
        },
        telegram(s) {
            this.openPopup('https://t.me/share/url?url=' + encodeURIComponent(s.permalink) + '&text=' + encodeURIComponent(s.title))
        },
        twitter(s) {
            this.openPopup('https://twitter.com/share?url=' + encodeURIComponent(s.permalink) + '&text=' + encodeURIComponent(s.title));
        },
        isKakaoAvailable() {
            return window.hasOwnProperty('Kakao') && 'object' === typeof window.Kakao;
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        let loadKakaoApi = false,
            loadPinterest = false;

        document.querySelectorAll('[data-nss]').forEach(function (elem) {
            const service = elem.dataset.nss;
            if (!loadKakaoApi && ('kakaoTalk' === service || 'kakaoStory' === service)) {
                loadKakaoApi = true;
            } else if ('pinterest' === service) {
                loadPinterest = true;
            }
            elem.addEventListener('click', function (e) {
                const target = e.currentTarget,
                    type = target.dataset.nss;
                if (target.tagName === 'A' && target.classList.contains('share')) {
                    e.preventDefault();
                }
                sharer.share(type);
            });
        });

        if (opts.kakaoApiKey.length > 0 && loadKakaoApi) {
            sharer.loadScript('https://developers.kakao.com/sdk/js/kakao.min.js', function () {
                if (sharer.isKakaoAvailable()) {
                    Kakao.init(opts.kakaoApiKey);
                }
            });
        }

        if (loadPinterest) {
            sharer.loadScript('//assets.pinterest.com/js/pinit.js');
        }
    });

    window.nss = sharer;
})();

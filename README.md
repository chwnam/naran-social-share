# 나란 소셜 공유 플러그인

워드프레스 포스트를 손쉽게 공유해 주는 플러그인입니다.


## 사용법
여타 플러그인처럼 설치 후 활성화시키면 됩니다.

관리자 > 소셜 공유 메뉴로 이동하여 적절히 설정하면 됩니다.


## 개발 가이드
나란 소셜 공유 플러그인은 플러그인 활성화시 즉시 모든 기능을 안락하게 사용가능한 사용자 친화적인 플러그인이기보다는,
개발자가 자신의 커스텀된 워드프레스 웹사이트를 제작하면서, 자신의 사이트의 tone & manner, look & feel 에 맞춰 자유롭게 변형하는 것이 가능한
소셜 공유 플러그인으로 기획하였습니다.

따라서 좀더 개발자-친화적인 이 플러그인을 잘 사용하기 위해서는 이 플러그인이 가지고 있는 여러 개발적인 요소들을 잘 파악하는 것이 중요합니다.
그러므로 여기서는 소셜 공유 커스텀에 도움이 될 사항들을 정리하여 소개합니다.

### 템플릿 오버라이드
`includes/templates/buttons.php`는 플러그인의 기본 소셜 공유 링크(버튼) 출력을 위한 템플릿입니다.

템플릿은 HTML 출력을 위한 부분으로 사이트의 복잡한 로직은 제거하고, HTML 코드 출력에만 전념하기 위한 장치입니다.
가급적 이 곳에는 HTML 구문을 출력하기 위한 용도로 사용하며, PHP 코드도 단지 PHP 변수 출력을 위해서만 사용하는 방향이 좋습니다.

플러그인에 있는 `includes/templates/buttons.php`는 단지 예시일 뿐입니다. 
이 템플릿을 수정해야 할 때는 직접 파일을 수정하지 말고, 오버라이드하세요.


#### 예시: buttons 템플릿을 오버라이드하는 방법
1. 테마 디렉토리에 'nss'라는 디렉토리를 만들고 'buttons.php' 파일을 복사합니다.
2. 복사한 `{theme}/nss/buttons.php` 를 수정합니다. 플러그인은 이 파일을 발견하면 이것을 우선적으로 읽어들일 것입니다.
3. 즉, 플러그인의 `includes/templates/` 후의 경로와 테마의 `{theme}/nss/` 후의 경로가 서로 일치해야 합니다.


### buttons 템플릿 설명
buttons 템플릿 상단에 다음과 같은 주석이 발견될 것입니다.
```php
<?php
/**
 * ...(생략)...
 * 
 * Context:
 * @var array<string, string> $all_avail Key: service identifier, value: service string.
 * @var array<string>         $available Keys of service to be displayed.
 * @var string                $icon_set  The current icon set.
 * @var string                $template  The template name.
 * @var string                $variant   The template variant.
 * @var array<string, string> $icons     Key: service identifier, value: URL to image.
 *
 */
```

`@var`라는 부분으로 시작하는 부분은 이 템플릿에 주어지는 콘텍스트 변수의 목록을 문서화한 것입니다.
각 변수들은 소셜 공유 목록을 출력하는 데 있어 중요한 정보를 담고 있습니다.

* $all_avail: 배열. 플러그인이 제공하는 모든 소셜 공유 서비스의 목록입니다. 키는 소셜 공유 식별자, 값은 서비스의 이름입니다.
* $available: 배열. 설정에서 체크한 소셜 공유 목록들의 식별자를 담은 배열입니다.
* $icon_set: 문자열. 설정에서 선택한 아이콘 셋 정보입니다.
* $template: 문자열. 현재 템플릿 이름.
* $variant: 문자열. 현재 템플릿 variant 이름.
* $icons: 배열. 현재 아이콘 셋의 아이콘 목록. 키는 소셜 공유 서비스 식별자, 값은 이미지 URL입니다.

각 버튼들은 `data-nss` 속성을 가지고 있습니다. `assets/js/front.js` 스크립트 파일에서, 이 속성을 가진 노드들에 대해
클릭 이벤트 핸들러로 속성의 값인 공유 서비스 식별자에 따라 각각 정해진 공유하기 작업을 진행합니다. 템플릿 오버라이드를 할 때 버튼의
`data-nss` 속성을 잊지 않도록 해 주세요.


#### $all_avail 예시
```php
$all_avail = [
    'facebook'  => __( 'Facebook', 'nss' ),
    'twitter'   => __( 'Twitter', 'nss' ),
    'linkedIn'  => __( 'LinkedIn', 'nss' ),
    'telegram'  => __( 'Telegram', 'nss' ),
    'kakaoTalk' => __( 'KakaoTalk', 'nss' ),
    'naverBlog' => __( 'Naver Blog', 'nss' ),
    'clipboard' => __( 'Clipboard', 'nss' ),
];
```

#### $available 예시
```php
$available = ['facebook', 'twitter', 'clipboard'];
```


#### $icons 예시
```
$icons = [
    'facebook'  => 'https://sample.com/wp-content/plugins/naran-social-login/assets/img/facebook.png',
    'twitter'   => 'https://sample.com/wp-content/plugins/naran-social-login/assets/img/twitter.png',
    'linkedIn'  => 'https://sample.com/wp-content/plugins/naran-social-login/assets/img/linked-in.png',
    'telegram'  => 'https://sample.com/wp-content/plugins/naran-social-login/assets/img/telegram.png',
    'kakaoTalk' => 'https://sample.com/wp-content/plugins/naran-social-login/assets/img/kakao-talk.png',
    'naverBlog' => 'https://sample.com/wp-content/plugins/naran-social-login/assets/img/naver-blog.png',
    'clipboard' => 'https://sample.com/wp-content/plugins/naran-social-login/assets/img/share.png',
];
```


### 숏코드
만약 특정 페이지에서 기본으로 저장된 설정과는 다른 설정으로 공유 버튼을 출력해야 한다면, 숏코드를 사용하여 
그 페이지만을 위한 소셜 공유 버튼을 출력할 수 있습니다.

숏코드와 그 셋팅은 관리자 > 설정 > 표시 > 숏코드 가이드에서 참고하시면 됩니다.


### template과 variant
숏코드 가이드에서 'template'과 'variant'라는 항목을 찾을 수 있을 것입니다. 

이것은 get_template_part()의 개념과 유사합니다.

만약 숏코드에서 기본 템플릿 'buttons'이 아닌 다른 템플릿, 예를 들어 `{template}/nss/share-icons.php` 같이 전혀 새로운 파일을 만들고,
이것을 사용하기를 원한다면 template에 'share-icons'를 입력하면 됩니다.

variant는 기본 템플릿의 변형입니다.  예를 들어 특정 페이지 타입을 위한 'share-icons'의 변형이 필요한 경우,
이 변형의 이름을 'page155'라고 이름짓는다고 생각해봅니다. 그러면 우리는 `{template}/nss/share-icons-page155.php` 파일을 생성하고,
template에 'share-icons' 그대로, variant에 'page155'를 입력하는 것입니다.

물론 기본 템플릿 자체를 `share-icons-page155`라고 이름지어도 불러오는데는 전혀 문제가 없습니다.
그러나 이렇게 기본-변형 식으로 이름을 분절하여 입력하면 이점이 있습니다.

가령,`{template}/nss/share-icons-page155.php` 파일이 발견되지 않는 경우,
기본 템플릿 `{template}/nss/share-icons.php`을 대신 불러오게 할 수 있기 때문입니다.

이를 잘 활용하면 대안(fallback)을 제공하는 템플릿으로 응용 가능합니다. 숏코드 같은 고정된 문자열에서는 다소 활용도가 떨어질 수 있으나,
사실 이는 NSS_Template_Impl::render() 메소드에서 사용하는 방식을 그대로 따라한 것에 불과합니다.
동적인 요소들을 variant로 설정하고 액션이나 필터의 콜백에서 사용하는 경우에는 유용할 수 있습니다.


### 액션 목록

#### nss_initialized
소셜 공유 플러그인이 모두 초기화되고 난 후 호출되는 액션입니다. 추가 초기화 코드를 설정할 수 있습니다.

#### nss_prepare_settings
소셜 공유 플러그인 관리자 페이지에서 설정 필드들을 모두 준비하고 난 후 호출하는 액션입니다. 추가 필드를 설정할 수 있습니다.

#### nss_before_buttons_wrap
div.nss-buttons-wrap 요소 이전에 호출되어, 프론트에서 소셜 공유 버튼 출력 이전에 내용을 추가하고 싶을 때 사용할 수 있습니다.

단, 이 액션은 템플릿에 위치합니다. 만약 오버라이드된 템플릿에서 누락시키면 호출되지 않을 것입니다.

#### nss_before_buttons_list
div.nss-buttons-wrap 요소가 열린 다음, 버튼 목록이 출력되기 이전에 호출됩니다.

단, 이 액션은 템플릿에 위치합니다. 만약 오버라이드된 템플릿에서 누락시키면 호출되지 않을 것입니다.

#### nss_after_buttons_list
버튼 목록이 출력된 후, div.nss-buttons-wrap 요소가 닫히기 전 호출됩니다.

단, 이 액션은 템플릿에 위치합니다. 만약 오버라이드된 템플릿에서 누락시키면 호출되지 않을 것입니다.

#### nss_after_buttons_wrap
div.nss-buttons-wrap 요소가 닫히고 난 후 호출됩니다. 프론트에서 소셜 공유 버튼 출력 다음에 내용을 추가하고 싶을 때 사용할 수 있습니다.

단, 이 액션은 템플릿에 위치합니다. 만약 오버라이드된 템플릿에서 누락시키면 호출되지 않을 것입니다.

#### nss_before_option_form
관리자 설정 페이지에서 form 태그 출력 전에 호출됩니다.

#### nss_after_settings_fields
관리자 설정 페이지에서 form 내부에 여러 form 제어를 위한 숨김 요소를 출력한 후 호출됩니다.

#### nss_after_do_settings_sections
관리자 설정 페이지에서 소셜 로그인의 설정 필드를 모두 출력하고 난 후, 저장 버튼이 출력되기 전 호출됩니다.

#### nss_after_option_form
관리자 설정 페이지에서 form 요소를 닫고 난 후 호출됩니다. 

### 필터 목록

#### nss_script_debug
SCRIPT_DEBUG 상수 상태를 필터하는 역할입니다.

#### nss_locate_file_paths
템플릿 경로를 결정할 때 후보가 되는 경로들을 우선순위로 나열한 배열입니다.
경로 배열과 캐시 이름 2개를 인자로 받습니다.

1. 경로 배열: 경로의 목록. 우선순위가 높을수록 먼저 나열됩니다. 
            경로의 우선순위는 차일드 템플릿 > 부모 템플릿 > 플러그인 순입니다.
2. 캐시 이름: "{템플릿_타입}:{템플릿_이름}:{변형}:{확장자}"의 문자열입니다.
   * 템플릿 타입: 일반적인 템플릿이면, 'template'으로 고정된 문자열입니다.
   * 템플릿 이름: render() 함수 호출시 넣은 $relpath 인수입니다.
   * 변경: $variant 인수입니다. 기본은 공백입니다.
   * 확장자: $ext 인수입니다. 기본은 'php'입니다.

템플릿 경로의 후보를 추가할 때 사용할 수 있습니다.

```php
add_filter( 'nss_locate_file_paths', 'my_override_locate_file_paths', 10, 2 );

function my_override_locate_file_paths( $paths, $cache_name ) {
    list( $template_name, $relpath, $variant, $ext ) = explode(':', $cache_name );
    
    if ( 'template' === $template_name && 'something' === $relpath ) {
        $paths = array_merge(
            array ( plugin_dir_path( MY_MAIN_FILE ) . 'include/templates' ),
            $paths
        );
    }
    
    return $paths;
}
```

#### nss_located_path
우선순위에 의해 템플릿이 결정된 후, 결정된 템플릿을 완전히 뒤집을 수 있는 필터입니다.
총 5개의 인수를 요구합니다.

1. 발견된 경로: 읽을 템플릿 파일의 경로
2. 템플릿 타입
3. 템플릿 이름
4. 변형
5. 확장자


```php
add_filter( 'nss_located_path', 'my_override_located_path', 10, 5 );

function my_override_locate_file_paths( $path, $template_name, $relpath, $variant, $ext ) {
    if ( 'template' === $template_name && 'something' === $relpath ) {
        $path = plugin_dir_path( MY_MAIN_FILE ) . 'include/templates/my-template.php';
    }
    
    return $path;
}
```

### nss_available_services
플러그인이 제공할 수 있는 모든 소셜 공유 서비스의 목록을 필터합니다.

```php
// My Service를 'myService' 식별자로 추가.
add_filter( 'nss_available_services', 'my_override_available_services' );

function my_override_available_services( $services ) {
    $services['myService'] = 'My Service';
    
    return $path;
}
```

### nss_icon_sets
플러그인의 아이콘 셋 목록을 필터합니다.

```php
// My Service 아이콘 및 변곃된 아이콘 셋 추가.
add_filter( 'nss_icon_sets', 'my_override_nss_icon_sets' );

function my_override_nss_icon_sets( $icons ) {
    $img_url = plugin_dir_url( MY_MAIN_FILE );
    
    // 기본 셋에 myService 아이콘 추가.
    $icons['default']['myService'] = $img_url . 'default-my-service.png';
    
    // dark 아이콘 셋 추가.
    $icons['dark'] = [
        'facebook'  => $img_url . 'dark-facebook.png',
        'twitter'   => $img_url . 'dark-twitter.png',
        'linkedIn'  => $img_url . 'dark-linked-in.png',
        'telegram'  => $img_url . 'dark-telegram.png',
        'kakaoTalk' => $img_url . 'dark-kakao-talk.png',
        'naverBlog' => $img_url . 'dark-naver-blog.png',
        'clipboard' => $img_url . 'dark-share.png',
        'myService' => $img_url . 'dark-my-service.png',
    ];
    
    return $icons;
}
```

### nss_sharable
소셜 공유 페이지를 출력할지를 결정하는 필터입니다.


### nss_share_params
소셜 공유 페이지를 출력하기 위한 자바스크립트의 옵션 값을 필터합니다.
필터하는 대상은 연관 배열이며, 이 배열은 다음처럼 구성되어 있습니다.

* title: 포스트의 제목입니다.
* thumbnail: 포스트의 대표 이미지가 있다면, URL을 저장하고 있습니다.
* permalink: 이 포스트의 URL입니다.


### nss_buttons_context
'buttons' 템플릿을 출력하기 위한 콘텍스트 변수를 필터합니다.
빌터하는 대상은 연관 배열입니다. 이 배열의 키는 템플릿에서 변수로 사용됩니다.

'buttons 템플릿 설명' 부분을 참고하세요.
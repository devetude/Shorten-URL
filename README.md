# Shorten URL이란?

**Shorten URL**은 긴 URL을 짧은 URL로 변경해주는 웹 사이트입니다.
> **대표적인 예시 사이트:**
> - **Google**의 https://goo.gl/
> - **’Twitter’**의 https://t.co

# 업데이트 내역
현재 최신버젼 : **v1.0.6**

> **업데이트 내역:**
> - v1.0.0 : 프로젝트 첫번째 공개
> - v1.0.5 : 클립보드를 이용해서 단축된 URL을 복사하는 기능 추가
> - v1.0.6 : 모바일 환경에서 클립보드 기능 버그 수정

# 미리보기
**http://su.devetude.net/** (현재 운영중이 아닙니다.)

# 설치환경
Shorten URL은 다음과 같은 APM 환경에서 동작합니다.
> **APM 버젼:**
> - apache (v2.2.15)
> - php (v5.3.3)
> - mysql (v5.1.71)

# 의존성
Shorten URL은 다음과 같은 반드시 필요한 2가지 **의존성 프로젝트**가 있습니다.
> **목록:**
> - **fhc-framework (https://github.com/flrngel/FHC-Framework.git)**
> - **apache rewrite_mod (http://httpd.apache.org/docs/current/mod/mod_rewrite.html)**

# 설치순서
> 1. **명령프롬프트** 혹은 **터미널**에서 ```git clone https://github.com/devetude/Shorten-URL.git```을 입력해주세요.
> 2. **MySQL**에서 **데이터베이스**(예 : devetude_su)를 **생성**해주세요.
> 3. **’Shorten-URL > db > url.sql’**을 이용하여 **url 테이블**을 생성하신 데이터베이스에 **생성**해주세요.
> 4. **’Shorten-URL > classes > DB.php’**에서 데이터베이스 **정보(Database, Host, User, Password)**를 **수정**해주세요.
> 5. **Apache Vertual Host**에 **Shorten-URL 디렉토리**를 **추가**해주세요.

# 라이센스
본 프로젝트는 Apache 2.0 License를 따릅니다. http://www.apache.org/licenses/LICENSE-2.0

# 문의사항
기타 문의사항이 있으실 경우 아래의 **문의 수단**으로 연락해주세요.
> **문의 수단:**
> - 메일 : **devetude@naver.com** 또는 **devetude@gmail.com**
> - github : **https://github.com/devetude/Shorten-URL/issues**

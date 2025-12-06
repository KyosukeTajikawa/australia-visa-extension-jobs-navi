# AUSSIE FARM NAVI/ファーム情報共有サービス
Laravel × React × AWS（ECS Fargate）で構築したフルスタック Web アプリです。

オーストラリアのファーム情報・レビュー・画像投稿を管理し、

ユーザー同士で安全に働ける環境づくりをサポートします。

技術要素： Docker / Nginx / GitHub Actions / S3 / RDS / SES / Fargate

主要機能： ファーム検索、レビュー投稿、画像アップロード、認証、S3画像管理 など

![AUSSIE FARM NAVI画像](/src/public/images/farmMain.png)

[![CI/CD](https://github.com/KyosukeTajikawa/australia-visa-extension-jobs-navi/actions/workflows/ci.yml/badge.svg)](https://github.com/KyosukeTajikawa/australia-visa-extension-jobs-navi/actions/workflows/ci.yml)
[![codecov](https://codecov.io/github/KyosukeTajikawa/australia-visa-extension-jobs-navi/branch/main/graph/badge.svg)](https://codecov.io/github/KyosukeTajikawa/australia-visa-extension-jobs-navi)
![PHP](https://img.shields.io/badge/PHP-8.3.28-blue)
![Laravel](https://img.shields.io/badge/Laravel-12.0-ff2d20?logo=laravel&logoColor=white)
![Inertia.js](https://img.shields.io/badge/Inertia.js-Laravel_×_React_bridge-59666C)
![React](https://img.shields.io/badge/React-18.2.0-61DAFB?logo=react&logoColor=black)
![TypeScript](https://img.shields.io/badge/TypeScript-5.9.2-3178C6?logo=typescript&logoColor=white)
![ChakraUI](https://img.shields.io/badge/Chakra_UI-2.8.2-319795?logo=chakraui&logoColor=white)
![Node.js](https://img.shields.io/badge/Node.js(Vite_build)-20.19.5-339933?logo=node.js&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)
![AWS](https://img.shields.io/badge/AWS-Cloud_Services-FF9900?logo=amazonaws&logoColor=white)
![ECS](https://img.shields.io/badge/ECS-Fargate-8A2BE2?logo=amazonaws&logoColor=white)
![RDS](https://img.shields.io/badge/RDS-MySQL-527FFF?logo=amazonrds&logoColor=white)
![S3](https://img.shields.io/badge/S3-Storage-569A31?logo=amazons3&logoColor=white)
![SES](https://img.shields.io/badge/SES-Email_Service-DD344C?logo=amazonses&logoColor=white)

## サービス概要
AUSSIE FARM NAVIは、「ファーム探しがもっと楽に安全に！」という想いから作られた、無料のファーム情報共有サービスです。

わずか2ステップで旅行プランを共有できる直感的なUIで、ユーザーの面倒な旅行の準備をサポートします。

## 開発背景
私自身、オーストラリアでワーキングホリデー制度を利用して2年間生活していました。
ワーキングホリデー制度では、ビザを延長するために 1 年ごとに更新が必要で、
更新には「政府指定の仕事（例：農場＝ファームでの就労）」に従事する必要があります。

私が初めてファームの仕事を探した際、
「どのように探せばいいのか分からない」
「信頼できる情報源がない」
と非常に苦労しました。

実際、ファーム探しのプラットフォームはほとんど存在せず、
現在でも多くの人が 友人の紹介や口コミだけ を頼りに探している状況です。
当時の私と同じように、
「情報不足によって苦労する人を少しでも減らしたい」
という思いから、このアプリを開発しました。

このサービスが、ワーホリで訪豪する方々の不安を軽減し、
安全かつスムーズにファームを探せる支えとなれば幸いです。

## ▼ サービスURL
https://aussie-farm-navi.com

### ゲスト用アカウント
メールアドレス：guest@example.com

パスワード：guest123

レスポンシブ対応済のため、PCでもスマートフォンでも快適にご利用いただけます。

## ▼ 紹介記事(Qiita)
独学で未経験のモダンな技術を学習してポートフォリオを作るまで【Laravel / React / AWS / Docker / GitHub Actions】

開発背景や、サービスのリリースまでに勉強したことなどをまとめています。

## メイン機能の使い方
<p align="center">
  <img src="/src/public/images/readme1.gif" width="250px"/>
  <img src="/src/public/images/readme2.gif" width="250px"/>
  <img src="/src/public/images/readme3.gif" width="250px"/>
</p>

##　管理画面
<p align="center">
  <img src="/src/public/images/admin-dashboard.gif" width="250px"/>
  <img src="/src/public/images/admin-user.gif" width="250px"/>
  <img src="/src/public/images/admin-detail.gif" width="250px"/>
</p>

## 使用技術一覧

### バックエンド
- PHP 8.3.28  
- Laravel 12.0  
- Inertia.js（Laravel × React ブリッジ）

### フロントエンド
- TypeScript 5.9.2  
- React 18.2.0  
- Chakra UI 2.8.2  
- ビルドツール: Vite（Node.js 20.19.5）

### テスト
- PHPUnit

### インフラ
- AWS  
  - VPC  
  - Route 53  
  - Certificate Manager  
  - ALB  
  - ECS Fargate  
  - ECR  
  - RDS MySQL  
  - S3（画像ストレージ）  
  - SES（メール送信）  
- Nginx

### 環境構築
- Docker / Docker Compose

### CI / CD
- GitHub Actions

### 認証
- Laravel の認証機能（メールアドレス・パスワード認証）

## 主要対応一覧

### ユーザー向け（フロントエンド機能）
**機能**
- メールアドレスとパスワードを利用したユーザー登録 / ログイン機能  
- ユーザー情報変更機能  
- パスワード再設定機能（AWS SES によるメール送信）  
- ユーザー削除（退会）機能  

- ファームの **作成 / 更新 / 削除機能**  
- ファームの **検索機能（条件検索）**  
- ファーム一覧のページネーション機能  
- ファーム画像の **登録 / アップロード / 削除機能（S3 連携）**  

- レビューの **作成 / 修正機能**  
- レビュー評価の平均値算出機能  

- お気に入り（Favorite）機能  
- トースト通知（成功・エラー表示）  
- ローディング画面  
- モーダル画面の表示（画像拡大、レビュー詳細、検索条件変更など）  

- **レスポンシブデザイン対応（スマホ / タブレット / PC）**

---

### 非ユーザー向け（ゲスト向け）
- ログインしていないユーザーでもファーム一覧・詳細を閲覧可能
- 未ログインユーザーが特定の操作を行おうとした時にログインを促すモーダル表示機能
- ファーム検索機能の一部を利用可能  

---

### システム / インフラ
- Docker による開発環境のコンテナ化  
- AWS を利用した本番環境構築  
  - VPC / ALB / ECS Fargate / ECR  
  - RDS MySQL  
  - S3（画像ストレージ）  
  - Route53（DNS ホスティング：お名前.com で取得したドメインを委譲）
  - Certificate Manager（SSL化）  
  - SES（パスワードリセットメール）  

- お名前.com によるドメイン取得  
- Nginx によるフロントリバースプロキシ構成  

---

### バックエンド
- Laravel 12  
- Inertia.js（Laravel × React ブリッジ）  
- PHPUnit によるバックエンドテスト  
- Laravel Pint による PHP コードフォーマット  
- Laravel Sanctum による認証  

---

### CI / CD
- **CI（継続的インテグレーション）：GitHub Actions**
  - PHPUnit テストの自動実行
  - Docker イメージのビルド & Docker Hub へのプッシュ

- **CD（継続的デリバリー／継続的デプロイ）：ECS Fargate**
  - 新しい Docker イメージを自動的に ECS タスク定義へ反映
  - ECS サービスを更新し、本番環境へ自動デプロイ


---

### フロントエンド
- React / TypeScript  
- Chakra UI による UI コンポーネント  
- Vite による高速ビルド  
- Axios を使った API 通信  

---

### テスト / セキュリティ
**クロスブラウザテスト**

- **PC**
  - Windows10 / 11: Google Chrome / Firefox / Edge  
  - macOS: Google Chrome / Firefox / Safari  

- **スマートフォン**
  - Android: Google Chrome  
  - iOS: Safari

 ###  苦労した点/難しかった点
 
- **レビュー平均値・星評価をリアルタイム集計**  
  - レビュー一覧（farm_rating）から平均スコアと 5〜1の新しいレビューを計算し、
    小数第1位までの平均値と 0.5 刻みの星アイコンを動的に表示しました。
    
    useMemo で不要な再計算を避けつつ、最大件数を基準にした棒グラフで
    評価の偏り（どの★が多いか）も可視化しました。


## インフラ構成図
![インフラ構成図](/src/public/images/AWS.png)

## ER図
![ER図](/src/public/images/ER.png)








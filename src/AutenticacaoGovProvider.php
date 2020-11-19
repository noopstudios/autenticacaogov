<?php

namespace Noop\AutenticacaoGov;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class AutenticacaoGovProvider extends AbstractProvider implements ProviderInterface {

    /**
     * Separator beteween scopes
     * @var string
     */
    protected $scopeSeparator = ' ';

    /**
     * Autenticacao.Gov Scopes
     */
    const SCOPE_NIC = 'http://interop.gov.pt/MDC/Cidadao/NIC';
    const SCOPE_NOMEPROPRIO = 'http://interop.gov.pt/MDC/Cidadao/NomeProprio';
    const SCOPE_NOMEAPELIDO	 = 'http://interop.gov.pt/MDC/Cidadao/NomeApelido';
    const SCOPE_DATANASCIMENTO	 = 'http://interop.gov.pt/MDC/Cidadao/DataNascimento';
    const SCOPE_NOMECOMPLETO	 = 'http://interop.gov.pt/MDC/Cidadao/NomeCompleto';
    const SCOPE_NIF	 = 'http://interop.gov.pt/MDC/Cidadao/NIF';
    const SCOPE_NISS	 = 'http://interop.gov.pt/MDC/Cidadao/NISS';
    const SCOPE_NSNS	 = 'http://interop.gov.pt/MDC/Cidadao/NSNS';
    const SCOPE_NIFCIFRADO	 = 'http://interop.gov.pt/MDC/Cidadao/NIFCifrado';
    const SCOPE_NISSCIFRADO	 = 'http://interop.gov.pt/MDC/Cidadao/NISSCifrado';
    const SCOPE_NICCIFRADO	 = 'http://interop.gov.pt/MDC/Cidadao/NICCifrado';
    const SCOPE_NSNSCIFRADO	 = 'http://interop.gov.pt/MDC/Cidadao/NSNSCifrado';
    const SCOPE_NACIONALIDADE	 = 'http://interop.gov.pt/MDC/Cidadao/Nacionalidade';
    const SCOPE_IDADE	 = 'http://interop.gov.pt/MDC/Cidadao/Idade';
    const SCOPE_IDADESUPERIORA	 = 'http://interop.gov.pt/MDC/Cidadao/IdadeSuperiorA';
    const SCOPE_PASSPORT	 = 'http://interop.gov.pt/MDC/Cidadao/Passport';
    const SCOPE_ALTURADADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/Altura';
    const SCOPE_ASSINATURADADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/Assinatura';
    const SCOPE_CONTACTOSDADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/ContactosXML';
    const SCOPE_CORREIOELECTRONICODADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/CorreioElectronico';
    const SCOPE_DATANASCIMENTODADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/DataNascimento';
    const SCOPE_DATAVALIDADEDADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/DataValidade';
    const SCOPE_FOTODADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/Foto';
    const SCOPE_INDICATIVOTELEFONEMOVELDADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/IndicativoTelefoneMovel';
    const SCOPE_NACIONALIDADEDADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/Nacionalidade';
    const SCOPE_NODOCUMENTODADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/NoDocumento';
    const SCOPE_NOMEAPELIDODADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/NomeApelido';
    const SCOPE_NOMEAPELIDOMAEDADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/NomeApelidoMae';
    const SCOPE_NOMEAPELIDOPAIDADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/NomeApelidoPai';
    const SCOPE_NOMEPROPRIODADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/NomeProprio';
    const SCOPE_NOMEPROPRIOMAEDADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/NomeProprioMae';
    const SCOPE_NOMEPROPRIOPAIDADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/NomeProprioPai';
    const SCOPE_NUMEROTELEFONEMOVELDADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/NumeroTelefoneMovel';
    const SCOPE_SEXODADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/Sexo';
    const SCOPE_MORADADADOSCC	 = 'http://interop.gov.pt/DadosCC/Cidadao/MoradaXML';
    const SCOPE_NOMEADSE	 = 'http://interop.gov.pt/ADSE/Cidadao/Nome';
    const SCOPE_NUMEROBENEFICIARIOADSE	 = 'http://interop.gov.pt/ADSE/Cidadao/NumeroBeneficiario';
    const SCOPE_QUALIDADEADSE	 = 'http://interop.gov.pt/ADSE/Cidadao/Qualidade';
    const SCOPE_SITUACAOADSE	 = 'http://interop.gov.pt/ADSE/Cidadao/Situacao';
    const SCOPE_DATAVALIDADEADSE	 = 'http://interop.gov.pt/ADSE/Cidadao/DataValidade';
    const SCOPE_NOMEPROPRIOIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/NomeProprio';
    const SCOPE_NOMEAPELIDOIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/NomeApelido';
    const SCOPE_LOCALNASCIMENTOIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/LocalNascimento';
    const SCOPE_DATANASCIMENTOIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/DataNascimento';
    const SCOPE_NOCARTAIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/NoCarta';
    const SCOPE_DATAEMISSAOIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/DataEmissao';
    const SCOPE_ENTIDADEEMISSORAIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/EntidadeEmissora';
    const SCOPE_ESTADOIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/Estado';
    const SCOPE_CATEGORIASIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/Categorias';
    const SCOPE_DIGITOCARTAIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/DigitoCarta';
    const SCOPE_DIGITOCONTROLOIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/DigitoControlo';
    const SCOPE_NOCONTROLOIMT	 = 'http://interop.gov.pt/IMTT/Cidadao/NoControlo';
    const SCOPE_ATRIBUTOSEMPRESARIAISSCAP	 = 'http://interop.gov.pt/SCCC';

    /**
     * Internal Rules do edit each value returned by Resource API
     */
    const RULE_DO_NOTHING = 0;
    const RULE_STR_TITLE = 1;
    const RULE_CARBON_D_M_Y = 2;
    const RULE_CARBON_Y_M_D = 3;
    const RULE_XML = 4;

    protected $rules = array(
        'identity_card_number' => self::RULE_DO_NOTHING,
        'own_names' => self::RULE_STR_TITLE,
        'nicknames' =>  self::RULE_STR_TITLE,
        'birth_date' => self::RULE_CARBON_D_M_Y,
        'name' =>  self::RULE_STR_TITLE,
        'tax_identification_number' => self::RULE_DO_NOTHING,
        'social_security_number' =>  self::RULE_DO_NOTHING,
        'national_health_service_number' =>  self::RULE_DO_NOTHING,
        'encrypted_tax_identification_number' =>  self::RULE_DO_NOTHING,
        'encrypted_social_security_number' =>  self::RULE_DO_NOTHING,
        'encrypted_identity_card_number' =>  self::RULE_DO_NOTHING,
        'encrypted_national_health_service_number' =>  self::RULE_DO_NOTHING,
        'nationality' =>  self::RULE_DO_NOTHING,
        'age' =>  self::RULE_DO_NOTHING,
        'older_than' =>  self::RULE_DO_NOTHING,
        'passport' =>  self::RULE_DO_NOTHING,
        'height_data_identity_card' =>  self::RULE_DO_NOTHING,
        'data_signature_identity_card' =>  self::RULE_DO_NOTHING,
        'contact_details_identity_card' => self::RULE_DO_NOTHING,
        'data_email_identity_card' =>  self::RULE_DO_NOTHING,
        'birth_date_identity_card' =>  self::RULE_CARBON_Y_M_D,
        'expiration_data_identity_card' =>  self::RULE_CARBON_Y_M_D,
        'photograph_identity_card' =>  self::RULE_DO_NOTHING,
        'telephone_code_identity_card' =>  self::RULE_DO_NOTHING,
        'nationality_identity_card' =>  self::RULE_DO_NOTHING,
        'document_number_identity_card' =>  self::RULE_DO_NOTHING,
        'first_name_identity_card' =>  self::RULE_STR_TITLE,
        'mothers_nickname_identity_card' =>  self::RULE_STR_TITLE,
        'fathers_nickname_identity_card' =>  self::RULE_STR_TITLE,
        'own_name_identity_card' =>  self::RULE_STR_TITLE,
        'mothers_own_name_identity_card' =>  self::RULE_STR_TITLE,
        'fathers_own_name_identity_card' => self::RULE_STR_TITLE,
        'mobile_phone_number_identity_card' =>  self::RULE_DO_NOTHING,
        'sex_identity_card' =>  self::RULE_DO_NOTHING,
        'address_data_identity_card' => self::RULE_XML,
        'adse_name' =>  self::RULE_STR_TITLE,
        'number_of_beneficiary_of_adse' =>  self::RULE_DO_NOTHING,
        'adse_quality' =>  self::RULE_DO_NOTHING,
        'adse_situation' =>  self::RULE_DO_NOTHING,
        'adse_expiration_date' =>  self::RULE_CARBON_Y_M_D,
        'imt_own_name' =>  self::RULE_STR_TITLE,
        'imt_nickname' =>  self::RULE_STR_TITLE,
        'imt_birthplace' =>  self::RULE_STR_TITLE,
        'imt_birth_date' =>  self::RULE_CARBON_D_M_Y,
        'imt_letter_number' =>  self::RULE_DO_NOTHING,
        'imt_issuance_date' =>  self::RULE_CARBON_Y_M_D,
        'imt_issuing_entity' =>  self::RULE_DO_NOTHING,
        'imt_state' =>  self::RULE_DO_NOTHING,
        'imt_categories' =>  self::RULE_DO_NOTHING,
        'imt_type_letter' =>  self::RULE_DO_NOTHING,
        'imt_type_control' =>  self::RULE_DO_NOTHING,
        'imt_control_number' =>  self::RULE_DO_NOTHING,
        'scap_business_attributes' => self::RULE_STR_TITLE,
    );

    /**
     * Internal API endpoint's urls for example:
     * for request NomeProprio the full url is => http://interop.gov.pt/MDC/Cidadao/NomeProprio
     * for more information read Atributos_FA_PR contained in Autencicao.GOV documentation
     */
    protected $fullScope = array(
        'NIC' => 'http://interop.gov.pt/MDC/Cidadao/NIC',
        'NomeProprio' => 'http://interop.gov.pt/MDC/Cidadao/NomeProprio',
        'NomeApelido' => 'http://interop.gov.pt/MDC/Cidadao/NomeApelido',
        'DataNascimento' => 'http://interop.gov.pt/MDC/Cidadao/DataNascimento',
        'NomeCompleto' => 'http://interop.gov.pt/MDC/Cidadao/NomeCompleto',
        'NIF' => 'http://interop.gov.pt/MDC/Cidadao/NIF',
        'NISS' => 'http://interop.gov.pt/MDC/Cidadao/NISS',
        'NSNS' => 'http://interop.gov.pt/MDC/Cidadao/NSNS',
        'NIFCifrado' => 'http://interop.gov.pt/MDC/Cidadao/NIFCifrado',
        'NISSCifrado' => 'http://interop.gov.pt/MDC/Cidadao/NISSCifrado',
        'NICCifrado' => 'http://interop.gov.pt/MDC/Cidadao/NICCifrado',
        'NSNSCifrado' => 'http://interop.gov.pt/MDC/Cidadao/NSNSCifrado',
        'Nacionalidade' => 'http://interop.gov.pt/MDC/Cidadao/Nacionalidade',
        'Idade' => 'http://interop.gov.pt/MDC/Cidadao/Idade',
        'IdadeSuperiorA' => 'http://interop.gov.pt/MDC/Cidadao/IdadeSuperiorA',
        'Passport' => 'http://interop.gov.pt/MDC/Cidadao/Passport',
        'AlturaDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/Altura',
        'AssinaturaDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/Assinatura',
        'ContactosDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/ContactosXML',
        'CorreioElectronicoDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/CorreioElectronico',
        'DataNascimentoDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/DataNascimento',
        'DataValidadeDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/DataValidade',
        'FotoDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/Foto',
        'IndicativoTelefoneMovelDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/IndicativoTelefoneMovel',
        'NacionalidadeDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/Nacionalidade',
        'NoDocumentoDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/NoDocumento',
        'NomeApelidoDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/NomeApelido',
        'NomeApelidoMaeDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/NomeApelidoMae',
        'NomeApelidoPaiDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/NomeApelidoPai',
        'NomeProprioDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/NomeProprio',
        'NomeProprioMaeDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/NomeProprioMae',
        'NomeProprioPaiDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/NomeProprioPai',
        'NumeroTelefoneMovelDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/NumeroTelefoneMovel',
        'SexoDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/Sexo',
        'MoradaDadosCC' => 'http://interop.gov.pt/DadosCC/Cidadao/MoradaXML',
        'NomeADSE' => 'http://interop.gov.pt/ADSE/Cidadao/Nome',
        'NumeroBeneficiarioADSE' => 'http://interop.gov.pt/ADSE/Cidadao/NumeroBeneficiario',
        'QualidadeADSE' => 'http://interop.gov.pt/ADSE/Cidadao/Qualidade',
        'SituacaoADSE' => 'http://interop.gov.pt/ADSE/Cidadao/Situacao',
        'DataValidadeADSE' => 'http://interop.gov.pt/ADSE/Cidadao/DataValidade',
        'NomeProprioIMT' => 'http://interop.gov.pt/IMTT/Cidadao/NomeProprio',
        'NomeApelidoIMT' => 'http://interop.gov.pt/IMTT/Cidadao/NomeApelido',
        'LocalNascimentoIMT' => 'http://interop.gov.pt/IMTT/Cidadao/LocalNascimento',
        'DataNascimentoIMT' => 'http://interop.gov.pt/IMTT/Cidadao/DataNascimento',
        'NoCartaIMT' => 'http://interop.gov.pt/IMTT/Cidadao/NoCarta',
        'DataEmissaoIMT' => 'http://interop.gov.pt/IMTT/Cidadao/DataEmissao',
        'EntidadeEmissoraIMT' => 'http://interop.gov.pt/IMTT/Cidadao/EntidadeEmissora',
        'EstadoIMT' => 'http://interop.gov.pt/IMTT/Cidadao/Estado',
        'CategoriasIMT' => 'http://interop.gov.pt/IMTT/Cidadao/Categorias',
        'DigitoCartaIMT' => 'http://interop.gov.pt/IMTT/Cidadao/DigitoCarta',
        'DigitoControloIMT' => 'http://interop.gov.pt/IMTT/Cidadao/DigitoControlo',
        'NoControloIMT' => 'http://interop.gov.pt/IMTT/Cidadao/NoControlo',
        'AtributosEmpresariaisSCAP' => 'http://interop.gov.pt/SCCC',
    );

    /**
     * Relation between $fullScope of the key's and name of the key's
     * that will be returned by mapUserToObject
     */
    private $keysArray = array(
        'NIC' => 'identity_card_number',
        'NomeProprio' => 'own_names',
        'NomeApelido' => 'nicknames',
        'DataNascimento' => 'birth_date',
        'NomeCompleto' => 'name',
        'NIF' => 'tax_identification_number',
        'NISS' => 'social_security_number',
        'NSNS' => 'national_health_service_number',
        'NIFCifrado' => 'encrypted_tax_identification_number',
        'NISSCifrado' => 'encrypted_social_security_number',
        'NICCifrado' => 'encrypted_identity_card_number',
        'NSNSCifrado' => 'encrypted_national_health_service_number',
        'Nacionalidade' => 'nationality',
        'Idade' => 'age',
        'IdadeSuperiorA' => 'older_than',
        'Passport' => 'passport',
        'AlturaDadosCC' => 'height_data_identity_card',
        'AssinaturaDadosCC' => 'data_signature_identity_card',
        'ContactosDadosCC' => 'contact_details_identity_card',
        'CorreioElectronicoDadosCC' => 'data_email_identity_card',
        'DataNascimentoDadosCC' => 'birth_date_identity_card',
        'DataValidadeDadosCC' => 'expiration_data_identity_card',
        'FotoDadosCC' => 'photograph_identity_card',
        'IndicativoTelefoneMovelDadosCC' => 'telephone code_identity_card',
        'NacionalidadeDadosCC' => 'nationality_identity_card',
        'NoDocumentoDadosCC' => 'document_number_identity_card',
        'NomeApelidoDadosCC' => 'first_name_identity_card',
        'NomeApelidoMaeDadosCC' => 'mothers_nickname_identity_card',
        'NomeApelidoPaiDadosCC' => 'fathers_nickname_identity_card',
        'NomeProprioDadosCC' => 'own_name_identity_card',
        'NomeProprioMaeDadosCC' => 'mothers_own_name_identity_card',
        'NomeProprioPaiDadosCC' => 'fathers_own_name_identity_card',
        'NumeroTelefoneMovelDadosCC' => 'mobile_phone_number__identity_card',
        'SexoDadosCC' => 'sex_identity_card',
        'MoradaDadosCC' => 'address_data_identity_card',
        'NomeADSE' => 'adse_name',
        'NumeroBeneficiarioADSE' => 'number_of_beneficiary_of_adse',
        'QualidadeADSE' => 'adse_quality',
        'SituacaoADSE' => 'adse_situation',
        'DataValidadeADSE' => 'adse_expiration_date',
        'NomeProprioIMT' => 'imt_own_name',
        'NomeApelidoIMT' => 'imt_nickname',
        'LocalNascimentoIMT' => 'imt_birthplace',
        'DataNascimentoIMT' => 'imt_birth_date',
        'NoCartaIMT' => 'imt_letter_number',
        'DataEmissaoIMT' => 'imt_issuance_date',
        'EntidadeEmissoraIMT' => 'imt_issuing_entity',
        'EstadoIMT' => 'imt_state',
        'CategoriasIMT' => 'imt_categories',
        'DigitoCartaIMT' => 'imt_type_letter',
        'DigitoControloIMT' => 'imt_type_control',
        'NoControloIMT' => 'imt_control_number',
        'AtributosEmpresariaisSCAP' => 'scap_business_attributes'
    );

    /**
     * Set scopes array as a list of endpoints base on an array $key => $value
     * @param array|string $scopes
     * @return AutenticacaoGovProvider|void
     */
    public function setScopes($scopes)
    {
        $this->scopes = array_values($scopes);
    }

    /**
     * Set specific scopes to the
     * @param array|string $scopes
     * @return $this|AutenticacaoGovProvider
     */
    public function scopes($scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * Builds the URL needed for the request of the token in this case
     * because the OAUTH2.0 flow used the implicit one
     * @param string $state
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(env('AUTENTICACAO_GOV_AUTHORIZATION_ENDPOINT'), $state);
    }

    /**
     * Builds the full URL used for the request of the token
     * user $url as the Authorization Endpoint then uses de $state
     * as one of the parameters used in getCodeFields
     * @param string $url
     * @param string $state
     * @return string
     */
    protected function buildAuthUrlFromBase($url, $state)
    {
        return $url.'?'.http_build_query($this->getCodeFields($state), '', '&', $this->encodingType);
    }

    /**
     * Redirect the user of the application to the provider's authentication screen.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        $state = null;

        if ($this->usesState()) {
            // The state in the current Autenticação.Gov is not used
            //$this->request->session()->put('state', $state = $this->getState());
        }

        return new RedirectResponse($this->getAuthUrl($state));
    }

    /**
     * Get the GET parameters for the token request.
     * Internal parameters used ($state is not used in current version):
     * client_id is the ClientID given by an authorized source of Autenticacao.Gov
     * redirect_uri is the full endpoint URL used to receive the GET request from Autenticacao.Gov
     * scope is the Resource API internal parameters requested
     * response_type is related with the fact that is being used response_type
     *
     * @param  string|null  $state
     * @return array
     */
    protected function getCodeFields($state = null)
    {
        if(empty($this->scopes)) $this->setScopes($this->fullScope);

        $fields = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'scope' => $this->formatScopes($this->getScopes(), $this->scopeSeparator),
            'response_type' => 'token',
        ];

        if ($this->usesState()) {
            $fields['state'] = $state;
        }

        return array_merge($fields, $this->parameters);
    }

    /**
     * Returns the full url of the static web page
     * @return mixed|string
     */
    protected function getTokenUrl()
    {
        return env('AUTENTICACAO_GOV_TOKEN_ENDPOINT');
    }

    /**
     * Not used in OAUTH2.0 implicit flow
     * @param string $code
     * @return array|void
     */
    public function getAccessTokenResponse($code)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
        ]);
    }

    /**
     * Not used in OAUTH2.0 implicit flow
     * @param string $code
     * @return array
     */
    protected function getTokenFields($code)
    {
        return [
            'response_type' => 'token',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'scope' => $this->formatScopes($this->getScopes(), ' '),
            'redirect_uri' => $this->redirectUrl,
        ];
    }

    /**
     * Get all data requested in the first Token request
     * The request structure is a request POST send to the Resource API endpoint
     * with the body as the following example:
     * {"token": "0e3e71b6-5ce5-462d-bb1c-b27b83c51e1f"}
     * Attributes Not used in the current version
     * The data in come in the following structure:
     * [{"name":"http://interop.gov.pt/MDC/Cidadao/NIC","value":"12345678"},
     *  {"name":"http://interop.gov.pt/MDC/Cidadao/NomeProprio","value":"Nome"},
     *  {"name":"http://interop.gov.pt/MDC/Cidadao/DataNascimento","value":"01-
     *  06-2002"},{"name":"http://interop.gov.pt/MDC/Cidadao/
     *  NIF","value":"123456789"}]
     *
     * @param string $token
     * @return array|mixed
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->post(env('AUTENTICACAO_GOV_RESOURCE_API'), array('form_params' => ['token' => $token]));

        return json_decode($response->getBody(), true);
    }

    /**
     * Makes the relation between the JSON returned by getUserByToken
     * and the $key => $value arrays defined to parse the results
     * also associates to the object $user the Token and Expiration Time
     * @return \Laravel\Socialite\Contracts\User|User
     */
    public function user()
    {
        $user = $this->mapUserToObject($this->getUserByToken(
            $token = $this->request->input('access_token')
        ));

        return $user->setToken($token)
            ->setExpiresIn(($this->request->input('expires_in')));
    }

    /**
     * Receives an array generated by getUserByToken trough the post request
     * to the resource API with form_params passed in the body.
     * As return return a use Laravel\Socialite\Two\User object that represents the
     * associated user.
     *
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user)
    {
        /**
         * Makes a new array from:
         * [{"name":"http://interop.gov.pt/MDC/Cidadao/NIC","value":"12345678"},
         *  {"name":"http://interop.gov.pt/MDC/Cidadao/NomeProprio","value":"Nome"},
         *  {"name":"http://interop.gov.pt/MDC/Cidadao/DataNascimento","value":"01-
         *  06-2002"},{"name":"http://interop.gov.pt/MDC/Cidadao/
         *  NIF","value":"123456789"}]
         * To:
         * [{"NIC" => "12345678"},
         *  {"NomeProprio" => "Nome"},
         *  {"DataNascimento" => "01-06-2002"},
         *  {"NIF" => "123456789"}]
         */
        $mapUserArray = array();
        foreach($user as $key => $values){
            $mapUserArray[array_search($values['name'], $this->fullScope)] = $values['value'];
        }

        /**
         * Makes a new array from
         * [{"NIC" => "12345678"},
         *  {"NomeProprio" => "Nome"},
         *  {"DataNascimento" => "01-06-2002"},
         *  {"NIF" => "123456789"}]
         * To:
         * [{"identity_card" => "12345678"},
         *  {"own_names" => "Nome"},
         *  {"birth_date" => "01-06-2002"},
         *  {"tax_identification_number" => "123456789"},
         */
        $mapUserVar = array();
        foreach($this->keysArray as $nameKey => $dbValue){
            if(!empty($mapUserArray[$nameKey])){
                $mapUserVar[$dbValue] = $mapUserArray[$nameKey];
            }else{
                $mapUserVar[$dbValue] = null;
            }
        }

        /**
         * Laravel\Socialite\Two\User object
         */
        return (new User)->setRaw($user)->map(
            $this->filterBasedOnRule($mapUserVar)
        );
    }

    /**
     * Based on one of the five RULE const alters the value field from
     * given $mapUserVar
     * return a new array from:
     * [{"identity_card" => "12345678"},
     *  {"own_names" => "Nome"},
     *  {"birth_date" => "01-06-2002"},
     *  {"tax_identification_number" => "123456789"},
     * To the treated information array:
     * [{"identity_card" => "12345678"},
     *  {"own_names" => "Only First Char Of Name Will Be Upper Case"},
     *  {"birth_date" => CarbonObject},
     *  {"tax_identification_number" => "123456789"},
     * @param array $mapUserVar
     * @return array
     */
    private function filterBasedOnRule(array $mapUserVar){
        foreach($this->rules as $dbKey => $rule){
            if(array_key_exists($dbKey, $mapUserVar)){
                if(!empty($mapUserVar[$dbKey])) {
                    switch ($rule) {
                        case self::RULE_DO_NOTHING:
                            //$mapUserVar[$dbKey] = $mapUserVar[$dbKey];
                            break;
                        case self::RULE_STR_TITLE:
                            $mapUserVar[$dbKey] = Str::title($mapUserVar[$dbKey]);
                            break;
                        case self::RULE_CARBON_D_M_Y:
                            $mapUserVar[$dbKey] = Carbon::createFromFormat('d-m-Y', $mapUserVar[$dbKey]);
                            break;
                        case self::RULE_CARBON_Y_M_D:
                            $mapUserVar[$dbKey] = Carbon::createFromFormat('Y-m-d', $mapUserVar[$dbKey]);
                            break;
                        case self::RULE_XML:
                            if ($dbKey == 'address_data_identity_card') {
                                $moradasStructure =  json_decode(json_encode(simplexml_load_string($mapUserVar[$dbKey]), TRUE));
                                unset($mapUserVar[$dbKey]);
                                if(!empty($moradasStructure->Portuguesa)) $mapUserVar['address_data_nationality'] = 'Portuguesa';
                                if(!empty($moradasStructure->Portuguesa->Localidade)) $mapUserVar['address_data_council'] = $moradasStructure->Portuguesa->Localidade;
                                if(!empty($moradasStructure->Portuguesa->ViaTipo)) $mapUserVar['address_data_road_type'] = $moradasStructure->Portuguesa->ViaTipo;
                                if(!empty($moradasStructure->Portuguesa->ViaDesignacao)) $mapUserVar['address_data_road_name'] = $moradasStructure->Portuguesa->ViaDesignacao;
                                if(!empty($moradasStructure->Portuguesa->Porta)) $mapUserVar['address_data_road_door'] = $moradasStructure->Portuguesa->Porta;
                                if(!empty($moradasStructure->Portuguesa->CodigoPostalPortugues->CodigoPostal)) $mapUserVar['address_data_postal_code'] = $moradasStructure->Portuguesa->CodigoPostalPortugues->CodigoPostal;
                                if(!empty($moradasStructure->Portuguesa->CodigoPostalPortugues->AreaFuncional)) $mapUserVar['address_data_sub_postal_code'] = $moradasStructure->Portuguesa->CodigoPostalPortugues->AreaFuncional;
                                if(!empty($moradasStructure->Portuguesa->CodigoPostalPortugues->LocalidadePostal)) $mapUserVar['address_data_council_postal_code'] = $moradasStructure->Portuguesa->CodigoPostalPortugues->LocalidadePostal;
                            }
                            break;
                    }
                }
            }
        }
        return $mapUserVar;
    }
}

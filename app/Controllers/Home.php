<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\SettingModel;

class Home extends BaseController
{
	private $model;

	public function __construct() {
		$this->model = new OrderModel();
	}

    public function index()
    {
        return view('main', [
        	'page_title' => 'Daftar'
        ]);
    }

    public function apiGetAll()
    {
    	$query = $this->model->getAll();

    	$data = [];
    	foreach ($query as $key => $value) {
    		$detail = '<a class="item-detail" href="#" data-id="' . $value->id . '" title="Detail"><i class="far fa-file-alt"></i></a> ';
			$edit = '<a class="item-edit" href="#" data-id="' . $value->id . '" title="Edit"><i class="far fa-edit"></i></a> ';
			$hapus = '<a href="' . site_url('delete/'.$value->id) . '" data-id="' . $value->id . '" onclick="return confirm(\'Apa Anda yakin menghapus order ini?\')" title="Hapus"><i class="fas fa-trash-alt"></i></a>';

			$data[] = [
    			$key + 1,
                $value->tanggal,
                $value->status,
                $value->klasifikasi,
                $value->client_status,
                $value->client_name,
                $value->unit,
                $value->reference,
                $value->social_media_order,
                $value->social_media_account,
                $value->postdate,
                $value->post_qty,
                $value->cost,
                $value->other_brief,
                $detail . $edit . $hapus
            ];
    	}

    	return $this->response->setJSON($data);
    }

    public function apiAddProcess()
    {
    	if($this->request->getMethod() !== 'post') {
            return redirect()->to('home');
        }

    	$data = $this->request->getPost();
    	unset($data['id']);
    	// return $this->response->setJSON($data);

    	if( $this->model->insert($data) ) {
    		$insert_id = $this->model->insertID();
    		$smtp = (new SettingModel())->getRecipients();

            $body = $this->emailBody($insert_id);
    		if($smtp->getNumRows() > 0) {
    			$recipients_res = $smtp->getResult();
    			$recipients = explode(', ', $recipients_res[0]->value);
    			foreach ($recipients as $key => $val) {
    				$email = trim($val);
    				$this->sendEmail($email, $data['tanggal'], $body);
    			}
    		}
            
            $this->sendSpecificMail($data['social_media_account'], $data['tanggal'], $body);

    		$msg = 'Data berhasil ditambahkan';
    		session()->setFlashData('success', $msg);
    		$response = [
    			'success' => true,
    			'msg' => $msg,
    			'data' => [
    				'id' => $insert_id,
    			],
    		];
    	} else {
    		$response = [
    			'success' => false,
    			'msg' => '<p>' . implode('</p><p>', $this->model->errors()) . '</p>',
    			'data' => null,
    		];
    	}

    	return $this->response->setJSON($response);
    }

    private function sendSpecificMail($radio, $tanggal, $body)
    {
        $model = new SettingModel();
        $query = $model->getSpecificRecipient();

        if($query->getNumRows() > 0) {
            $data = $query->getResult();
            $specific_rec = json_decode($data[0]->value);

            if($radio === 'Ardan' && $specific_rec->ardan_recipient != '') {
                $rec = trim($specific_rec->ardan_recipient);
                $this->sendEmail($rec, $tanggal, $body);
            }

            if($radio === 'B Radio' && $specific_rec->bradio_recipient != '') {
                $rec = trim($specific_rec->bradio_recipient);
                $this->sendEmail($rec, $tanggal, $body);
            }

            if($radio === 'Cakra' && $specific_rec->cakra_recipient != '') {
                $rec = trim($specific_rec->cakra_recipient);
                $this->sendEmail($rec, $tanggal, $body);
            }
        }
        
        return;
    }

    public function apiGetById()
    {
    	$id = $this->request->getPost('id');
        // $modified = $this->request->getPost('modified') ?? false;

    	$query = $this->model->getById($id);

    	if($query == null) {

        	return $this->response->setJSON([
        		'success' => false,
        		'data' => null
        	]);
    	}

    	return $this->response->setJSON([
	    		'success' => true,
	    		'data' => $query
	    	]);
    }

    public function apiEditProcess()
    {        
    	$data = $this->request->getPost();

    	if( $this->model->save($data) ) {
    		$msg = 'Data berhasil diupdate';
    		session()->setFlashData('success', $msg);
    		$response = [
    			'success' => true,
    			'msg' => $msg,
    			'data' => [
    				'id' => $data['id'],
    			],
    		];
    	} else {
    		$response = [
    			'success' => false,
    			'msg' => '<p>' . implode('</p><p>', $this->model->errors()) . '</p>',
    			'data' => null,
    		];
    	}

    	return $this->response->setJSON($response);
    }

    public function delete($id)
    {
    	if($this->model->delete($id)) {
    		return redirect()->back()
    						->with('success', 'Data berhasil dihapus');
    	}

    	return redirect()->back()
    					->with('error', 'Data gagal dihapus');
    }

    public function setting()
    {
        $model = new SettingModel();
        $query = $model->getSpecificRecipient();

        $specifics = [];
        if($query->getNumRows() > 0) {
            $data = $query->getResult();
            $specific_rec = json_decode($data[0]->value);
            // dd($specific_rec);

            $specifics['id'] = $data[0]->id;
            // $specifics['data'] = json_decode($data[0]->value);
            $specifics['data']['ardan_recipient'] = $specific_rec->ardan_recipient;
            $specifics['data']['bradio_recipient'] = $specific_rec->bradio_recipient;
            $specifics['data']['cakra_recipient'] = $specific_rec->cakra_recipient;
        } else {
            $specifics['id'] = 0;
            $specifics['data'] = [
                    'ardan_recipient' => '',
                    'bradio_recipient' => '',
                    'cakra_recipient' => ''
                ];
        }

        // dd($specifics);

    	return view('setting', [
    		'page_title' => 'Setting',
            'specifics' => $specifics
    	]);
    }

    public function getRecipients()
    {
    	$query = (new SettingModel())->getRecipients();
    	if($query->getNumRows() > 0) {
    		$data = $query->getResult();
    		return $this->response->setJSON([
    			'success' => true,
    			'id' => $data[0]->id,
    			'data' => explode(', ', $data[0]->value)
    		]);
    	}
    }

    public function apiSettingStore()
    {
    	$email = $this->request->getPost('email');
    	$id = $this->request->getPost('recipients_id');
    	// return $this->response->setJSON($this->request->getPost('email'));

    	$model = new SettingModel();
    	$query = $model->getRecipients();

    	if($query->getNumRows() > 0) {
    		$data = [
    			'id' => $id,
    			'value' => ($email != null) ? implode(', ', $email) : ''
    		];
    		$save_data = $model->save($data);
    	} else {
    		$data = [
    			'field' => 'recipients',
    			'value' => ($email != null) ? implode(', ', $email) : ''
    		];
    		$save_data = $model->insert($data);
    	}

    	if($save_data) {
    		session()->setFlashData('success', 'Data berhasil diupdate');
    			return $this->response->setJSON([
    				'success' => true,
    				'data' => $email
    			]);
    		} else {
    			session()->setFlashData('error', 'Data gagal diupdate');
    			return $this->response->setJSON([
    				'success' => false,
    				'data' => null
    			]);
    		}
    }

    private function mailHeader()
    {
    	return view('Mail/mail_header');
    }

    private function mailFooter()
    {
    	return view('Mail/mail_footer');
    }

    private function emailBody($id)
    {
    	$query = $this->model->asObject()->find($id);

    	$str = '
    	<table class="tbl" border="1" bordercolor="#111111">
    	<tbody>
    	<tr>
    	<td>Status order</td>
    	<td>'.$query->status.'</td>
    	</tr>
    	<tr>
    	<td>Tanggal order</td>
    	<td>'.$query->tanggal.'</td>
    	</tr>
    	<tr>
    	<td>Klasifikasi order</td>
    	<td>'.$query->klasifikasi.'</td>
    	</tr>
    	<tr>
    	<td>Status klien</td>
    	<td>'.$query->client_status.'</td>
    	</tr>
    	<tr>
    	<td>Nama klien</td>
    	<td>'.$query->client_name.'</td>
    	</tr>
    	<tr>
    	<td>Unit pengorder</td>
    	<td>'.$query->unit.'</td>
    	</tr>
    	<tr>
    	<td>Nama pengorder</td>
    	<td>'.$query->reference.'</td>
    	</tr>
    	<tr>
    	<td>Order social media</td>
    	<td>'.$query->social_media_order.'</td>
    	</tr>
    	<tr>
    	<td>Akun social media</td>
    	<td>'.$query->social_media_account.'</td>
    	</tr>
    	<tr>
    	<td>Tanggal posting</td>
    	<td>'.$query->postdate.'</td>
    	</tr>
    	<tr>
    	<td>Kuantitas postingan</td>
    	<td>'.$query->post_qty.'</td>
    	</tr>
    	<tr>
    	<td>Total biaya</td>
    	<td>'.$query->cost.'</td>
    	</tr>
    	<tr>
    	<td>Brief lainnya</td>
    	<td>'.$query->other_brief.'</td>
    	</tr>
    	</tbody>
    	</table>';
    	return $this->mailHeader() . $str . $this->mailFooter();
    }

    private function sendEmail($email_addr, $tanggal, $body)
    {
    	$email = \Config\Services::email();
    	$email->clear(true);

    	$smtp_check = (new SettingModel())->getSMTP();
    	if($smtp_check->getNumRows() > 0) {
    		$data_smtp = $smtp_check->getResult();
    		$smtp = json_decode($data_smtp[0]->value);

	    	$config['SMTPHost']  = $smtp->SMTPHost;
	    	$config['SMTPUser'] = $smtp->SMTPUser;
	    	$config['SMTPPass'] = $smtp->SMTPPass;
	    	$config['SMTPPort']  = $smtp->SMTPPort;

	    	$email->initialize($config);

	    	$email->setFrom($smtp->SMTPUser, 'Admin AGDC');
	    	$email->setTo($email_addr);
	    	$email->setSubject('AGDC Internal Order Tanggal '. $tanggal);
	    	$email->setMessage($body);

	    	$email->send();

	    	return;
	    }

	    return;
    }

    public function getSMTPSetting()
    {
    	$model = new SettingModel();
    	$query = $model->getSMTP();

    	// $arr = [
    	// 	'host' => 'localhost',
    	// 	'user' => 'alfin'
    	// ];
    	// $json = '{"host":"localhost","user":"alfin"}';
    	// dd(json_decode($json));

    	if($query->getNumRows() > 0) {
    		$data = $query->getResult();
    		// dd($data);
    		$response = [
    			'success' => true,
    			'id' => $data[0]->id,
    			'data' => json_decode($data[0]->value)
    		];
    		return $this->response->setJSON($response);
    	} else {
    		$response = [
    			'success' => true,
    			'id' => 0,
    			'data' => [
    				'host' => '',
    				'user' => '',
    				'password' => '',
    				'encryption' => ''
    			]
    		];
    		return $this->response->setJSON($response);
    	}
    }

    public function storeSMTP()
    {
    	$data = $this->request->getPost();
    	$id = $data['smtp_id'];
    	unset($data['smtp_id']);
    	// return $this->response->setJSON(['id' => $id, 'data' => $data]);

    	$model = new SettingModel();
    	$query = $model->getSMTP();

    	if($query->getNumRows() > 0) {
    		$data = [
    			'id' => $id,
    			'value' => json_encode($data)
    		];
    		$save_data = $model->save($data);
    	} else {
    		$data = [
    			'field' => 'smtp',
    			'value' => json_encode($data)
    		];
    		$save_data = $model->insert($data);
    	}

    	if($save_data) {
	    	return $this->response->setJSON([
	    		'success' => true,
	    		'data' => $data
	    	]);
	    } else {
	    	return $this->response->setJSON([
	    		'success' => false,
	    		'data' => null
	    	]);
	    }
    }

    public function storeSpecificRecipient()
    {
        $data = $this->request->getPost();
        $id = $data['specifics_id'];
        unset($data['specifics_id']);
        // return $this->response->setJSON(['id' => $id, 'data' => $data]);

        $model = new SettingModel();
        $query = $model->getSpecificRecipient();

        if($query->getNumRows() > 0) {
            $data = [
                'id' => $id,
                'value' => json_encode($data)
            ];
            $save_data = $model->save($data);
        } else {
            $data = [
                'field' => 'specific_recipients',
                'value' => json_encode($data)
            ];
            $save_data = $model->insert($data);
        }

        if($save_data) {
            session()->setFlashData('success', 'Specific recipient berhasil diupdate');
            return $this->response->setJSON([
                'success' => true,
                'data' => $data
            ]);
        } else {
            session()->setFlashData('error', 'Specific recipient gagal diupdate');
            return $this->response->setJSON([
                'success' => false,
                'data' => null
            ]);
        }
    }
}
